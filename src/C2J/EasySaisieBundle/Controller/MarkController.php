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
use Doctrine\Common\Util\Debug;

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
     * @Route("/addBySubject/{subjectName}/{year}/{promotion_id}", name="mark_add_by_subject")
     * @Method("GET")
     * @Template()
     */    
    public function addBySubjectAction($subjectName, $year, $promotion_id) 
    {
        // $mark = new Mark();
        // $form = $this->createFormBuilder($mark)
        //             ->add('value', 'text')
        //             ->add('session', 'text')
        //             ->add('save', 'submit')
        //         ->getForm();

        // return array('form' => $form->createView());
        // if ($form->isValid()) {
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($entity);
            // $em->flush();

            // return $this->redirect($this->generateUrl('container_show', array('id' => $entity->getId())));
        // }

        $em = $this->getDoctrine()->getManager();
        $studentPromotions = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findAllStudentsInPromotionByYear($promotion_id, $year);

        return array(
            'studentPromotions' => $studentPromotions,
            'subject' => $subjectName
        );
    }

    /**
     * Lists all marks for every students from a promotion for the specified year.
     *
     * @Route("/list/{year}/{promotion_id}/{session}", name="mark_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction($year, $promotion_id, $session) 
    {
        $em = $this->getDoctrine()->getManager();
        $studentPromotions = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findAllStudentsInPromotionByYear($promotion_id, $year);
        $promotions = $em->getRepository('C2JEasySaisieBundle:Promotion')->findAllSubjectsByTusByContainerByPromotionByYear($promotion_id, $year);
        //var_dump($promotions);exit;
		
        $colspans = [];
        foreach ($promotions[0]->getContainers() as $container) {
            $containersColspan = 0; 
            foreach ($container->getTeachingUnits() as $tu) {
                $containersColspan++; // +1 for the average column
                foreach ($tu->getTeachingUnitSubjects() as $subject) {
                    $containersColspan++;
                }
            }
            $colspans[] = $containersColspan; 
        }        

        if(count($promotions) >= 1) {
            $containers = $promotions[0]->getContainers();

            $subjectsByTu = array();
            foreach ($containers as $container) {
                foreach ($container->getTeachingUnits() as $tu) {
                    foreach ($tu->getTeachingUnitSubjects() as $tus) {
                        $subjectsByTu[$tu->getCode()][] = array(
                            'tusId' => $tus->getId(),
                            'container' => $container->getName(),
                            'subject'           => array(
                                'id'            => $tus->getSubject()->getId(),
                                'name'          => $tus->getSubject()->getName(),
                                'abbreviation'  => $tus->getSubject()->getAbbreviation(),
                                'coeff'         => $tus->getCoeff()
                            )
                        );
                    }
                }
            }
        }
        else {
            $containers = array();
        }
        // asort($subjectsByTu); // Sort is necessary to display marks in the correct order in the view
        // var_dump($subjectsByTu['72m']);
        return array(
            'session' => $session,
            'studentPromotions' => $studentPromotions,
            'containers' => $containers,
            'containersColspan' => $colspans,
            'subjectsByTu' => $subjectsByTu
        );
    }

    /**
     * Creates a new Mark entity.
     *
     * @Route("/", name="mark_create")
     * @Method("POST")
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
                $tus = $em->getRepository('C2JEasySaisieBundle:TeachingUnitSubject')->find($request->request->get('tusid'));
                $sp = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->find($request->request->get('spid'));

                if (!$tus) {
                    throw $this->createNotFoundException('Unable to find TeachingUnitSubject entity.');
                }
                if (!$sp) {
                    throw $this->createNotFoundException('Unable to find StudentPromotion entity.');
                }
                $mark = new Mark();
                $mark   -> setTeachingUnitSubject($tus)
                        -> setStudentPromotion($sp);
            }

            // If the new value is not empty : set the mark value
            $value = $request->request->get('value');
            $session = $request->request->get('session');
            
            if($value != '') {
                $mark->setValue($value);
                $mark->setSession($session);
                $em->persist($mark);
            } 
            // Otherwise the mark needs to be deleted from the DB : delete
            else { 
                $em->remove($mark);
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
}
