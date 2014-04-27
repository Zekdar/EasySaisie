<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Mark;
use C2J\EasySaisieBundle\Form\MarkType;
use C2J\EasySaisieBundle\Form\StudentPromotionMarksType;
use Doctrine\Common\Util\Debug;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Mark controller.
 *
 * @Route("/mark")
 */
class MarkController extends Controller
{

    /**
     * Lists all promotion by year.
     *
     * @Route("/", name="mark")
     * @Method("GET")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findAllPromotionsByYearDistinct();        

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Adds marks for a given subject
     *
     * @Route("/addBySubject/{tucsId}/{subjectId}/{year}/{promotion_id}/{session}", name="mark_add_by_subject")
     * @Method({"GET", "POST"})
     * @Secure(roles="ROLE_PROF")
     * @Template()
     */    
    public function addBySubjectAction($tucsId, $subjectId, $year, $promotion_id, $session) 
    {
        if(isset($_POST['submit'])){
            for ($i = 0; $i < $_POST['marksCount']; $i++) { 
                $this->persistMark($_POST['markid'], $_POST['tucsId'], $_POST['spid'], $_POST['mark-'.$i], $_POST['session']);
            }
        }
        
        $em = $this->getDoctrine()->getManager();
        $studentPromotions = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findAllStudentsInPromotionByYearBySubject($promotion_id, $year, $subjectId);
        $tucs = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->find($tucsId);
        
        return array(
            'studentPromotions' => $studentPromotions,
            'subjectId' => $subjectId,
            'session' => $session,
            'tucs' => $tucs,
        );
    }

    /**
     * Lists all marks for every students from a promotion for the specified year.
     *
     * @Route("/list/{year}/{promotion_id}/{session}", name="mark_list")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("GET")
     * @Template()
     */
    public function listAction($year, $promotion_id, $session) 
    {
        $studentsList = $this->getRequest()->query->get('studentsList');

        $em = $this->getDoctrine()->getManager();

        // Display Session 2
        if($studentsList != '') {
            $studentsList = json_decode($studentsList);
            $studentPromotions = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findAllMarksForTheseStudentsByPromotionByYear($promotion_id, $year, $studentsList);
        }
        // Else display session 1 and PV Final
        else
            $studentPromotions = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findAllStudentsInPromotionByYear($promotion_id, $year);

        $promotions = $em->getRepository('C2JEasySaisieBundle:Promotion')->findAllSubjectsByTucsByContainerByPromotionByYear($promotion_id, $year);
        // var_dump($studentPromotions);exit;
        
		$colspans = [];	
		if(count($promotions) >= 1) {			
			foreach ($promotions[0]->getContainers() as $container) {
				$containersColspan = 0; 
				foreach ($container->getTeachingUnitContainers() as $tuc) {
					$containersColspan++; // +1 for the average column
					foreach ($tuc->getTeachingUnitContainerSubjects() as $subject) {
						$containersColspan++;
					}
				}
				$colspans[] = $containersColspan; 
			}   
		}

		$subjectsByTuc = array();
        if(count($promotions) >= 1) {
            $containers = $promotions[0]->getContainers();
            $minAvgToValidate = $promotions[0]->getMinAverageToValidate();
            
            $sumCoeffs = array();
            foreach ($containers as $container) {
                foreach ($container->getTeachingUnitContainers() as $tuc) {
                    $sum = 0;
                    foreach ($tuc->getTeachingUnitContainerSubjects() as $tucs) {
                        $subjectsByTuc[$tuc->getTeachingUnit()->getCode()][] = array(
                            'isCompensable' => $tuc->getTeachingUnit()->getIsCompensable(),
                            'tucsId' => $tucs->getId(),
                            'container' => $container->getName(),
                            'subject'           => array(
                                'id'            => $tucs->getSubject()->getId(),
                                'name'          => $tucs->getSubject()->getName(),
                                'abbreviation'  => $tucs->getSubject()->getAbbreviation(),
                                'coeff'         => $tucs->getCoeff()
                            )
                        );
                        $sum += $tucs->getCoeff();
                    }
                    $sumCoeffs[] = $sum;
                }
            }
        }
        else {
            $containers = array();
            $minAvgToValidate = '';
            $sumCoeffs = array();
        }
        // asort($subjectsByTu); // Sort is necessary to display marks in the correct order in the view
        // var_dump($subjectsByTu['72m']);
        return array(
            'sumCoeffs' => $sumCoeffs,
            'minAvgToValidate' => $minAvgToValidate,
            'session' => $session,
            'studentPromotions' => $studentPromotions,
            'containers' => $containers,
            'containersColspan' => $colspans,
            'subjectsByTuc' => $subjectsByTuc
        );
    }

    /**
     * Creates a new Mark entity.
     *
     * @Route("/", name="mark_create")
     * @Method("POST")
     * @Secure(roles="ROLE_PROF")
     * @Template("C2JEasySaisieBundle:Mark:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Mark();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mark_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Mark entity.
    *
    * @param Mark $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Mark $entity)
    {
        $form = $this->createForm(new MarkType(), $entity, array(
            'action' => $this->generateUrl('mark_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Mark entity.
     *
     * @Route("/new", name="mark_new")
     * @Method("GET")
     * @Secure(roles="ROLE_PROF")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mark();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Mark entity.
     *
     * @Route("/{id}", name="mark_show")
     * @Method("GET")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mark entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Mark entity.
     *
     * @Route("/{id}/edit", name="mark_edit")
     * @Method("GET")
     * @Secure(roles="ROLE_PROF")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mark entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Mark entity.
    *
    * @param Mark $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mark $entity)
    {
        $form = $this->createForm(new MarkType(), $entity, array(
            'action' => $this->generateUrl('mark_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Mark entity.
     *
     * @Route("/{id}", name="mark_update")
     * @Method("PUT")
     * @Secure(roles="ROLE_PROF")
     * @Template("C2JEasySaisieBundle:Mark:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mark entity.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mark_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Mark entity.
     *
     * @Route("/{id}", name="mark_delete")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mark entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mark'));
    }

    /**
     * Creates a form to delete a Mark entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mark_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * AJAX - Updates or Inserts a Mark in DB.
     *
     * @Route("/", name="mark_persist_ajax")
     * @Method("PUT")
     */    
    public function persistMarkAjax() 
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            
            // If mark exists ==> update
            $id = $request->request->get('pk');
            if (!empty($id)) {
                $mark = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

                if (!$mark) {
                    throw $this->createNotFoundException('Unable to find Mark entity.');
                }
            } 
            // Else ==> insert
            else {				
				//var_dump($request->request->get('tucsid'));exit;
                $tucs = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->find($request->request->get('tucsid'));
                $sp = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->find($request->request->get('spid'));

                if (!$tucs) {
                    throw $this->createNotFoundException('Unable to find TeachingUnitContainerSubject entity.');
                }
                if (!$sp) {
                    throw $this->createNotFoundException('Unable to find StudentPromotion entity.');
                }
                $mark = new Mark();
                $mark   -> setTeachingUnitContainerSubject($tucs)
                        -> setStudentPromotion($sp);
            }

            // If the new value is not empty : set the mark value
            $session = $request->request->get('session');
            $value = $request->request->get('value');
            if($value != '') {
                if($session == 1)
                    $mark->setValueS1($value);
                else
                    $mark->setValueS2($value);

                $em->persist($mark);
            } 
            // Otherwise the mark needs to be deleted from the DB : delete
            // Session1
            elseif ($session == 1) {
                $em->remove($mark);
            }
            // Session2
            else {
                if($mark->getValueS1() == '') {
                    $em->remove($mark); // S1 == '' ==> delete
                }
                else { // S1 != '' && S2 == '' ==> update to null
                    // Update 
                    $mark->setValueS2(null);
                }
            }

            $em->flush();

            $response = new Response(json_encode(array('markId' => $mark->getId())));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } 
        else {
            throw new HttpException(403, "Forbidden");
        }
    }

    /**
     * @Route("/", name="mark_persist")
     * @Method("PUT")
     */    
    public function persistMark($id = null, $tucsid = null, $spid = null, $value, $session) 
    {
        $request = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        
        // If mark exists ==> update
        
        if ($id != null) {
            $mark = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);


            if (!$mark) {
                throw $this->createNotFoundException('Unable to find Mark entity.');
            }
        } 
        // Else ==> insert
        else {              
            //var_dump($request->request->get('tucsid'));exit;
            $tucs = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->find($tucsid);
            $sp = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->find($spid);

            if (!$tucs) {
                throw $this->createNotFoundException('Unable to find TeachingUnitContainerSubject entity.');
            }
            if (!$sp) {
                throw $this->createNotFoundException('Unable to find StudentPromotion entity.');
            }
            $mark = new Mark();
            $mark   -> setTeachingUnitContainerSubject($tucs)
                    -> setStudentPromotion($sp);
        }

        // If the new value is not empty : set the mark value
        //$session = $request->request->get('session');
        //$value = $request->request->get('value');
        if($value != '') {
            if($session == 1)
                $mark->setValueS1($value);
            else
                $mark->setValueS2($value);

            $em->persist($mark);
        } 
        // Otherwise the mark needs to be deleted from the DB : delete
        // Session1
        elseif ($session == 1) {
            $em->remove($mark);
        }
        // Session2
        else {
            if($mark->getValueS1() == '') {
                $em->remove($mark); // S1 == '' ==> delete
            }
            else { // S1 != '' && S2 == '' ==> update to null
                // Update 
                $mark->setValueS2(null);
            }
        }

        // $em->flush();

        $response = new Response(json_encode(array('markId' => $mark->getId())));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
