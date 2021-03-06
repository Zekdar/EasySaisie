<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\StudentPromotion;
use C2J\EasySaisieBundle\Form\StudentPromotionType;

/**
 * StudentPromotion controller.
 *
 * @Route("/studentpromotion")
 */
class StudentPromotionController extends Controller
{

    /**
     * Lists all StudentPromotion entities.
     *
     * @Route("/", name="studentpromotion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new StudentPromotion entity.
     *
     * @Route("/", name="studentpromotion_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:StudentPromotion:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new StudentPromotion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
			$em = $this->getDoctrine()->getManager();
			
			$studentId=$entity->getStudent()->getId();
			$promotionId=$entity->getPromotion()->getId();

			$entity2 = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findBy(array('student' => $studentId, 'promotion' => $promotionId));
			
			if($entity2 == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'L\'étudiant a été ajouté dans la promotion avec succès !'
				);
				return $this->redirect($this->generateUrl('studentpromotion_show', array('id' => $entity->getId())));
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'L\'étudiant existe déjà dans la promotion !'
				);
				return $this->redirect($this->generateUrl('studentpromotion_new'));
			}  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a StudentPromotion entity.
    *
    * @param StudentPromotion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(StudentPromotion $entity)
    {
        $form = $this->createForm(new StudentPromotionType(), $entity, array(
            'action' => $this->generateUrl('studentpromotion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new StudentPromotion entity.
     *
     * @Route("/new", name="studentpromotion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new StudentPromotion();
		$request = Request::createFromGlobals();
		$request->getPathInfo();
        
		$studentId=$request->query->get('studentId');
		$promotionId=$request->query->get('promotionId');
		
		if($studentId != null) {  
			$em = $this->getDoctrine()->getManager();
			$entity2 = $em->getRepository('C2JEasySaisieBundle:Student')->find($studentId);
			$entity->setStudent($entity2);
		}
		
		if($promotionId != null) {  
			$em = $this->getDoctrine()->getManager();
			$entity2 = $em->getRepository('C2JEasySaisieBundle:Promotion')->find($promotionId);
			$entity->setPromotion($entity2);
		}
		
		$form   = $this->createCreateForm($entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a StudentPromotion entity.
     *
     * @Route("/{id}", name="studentpromotion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StudentPromotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing StudentPromotion entity.
     *
     * @Route("/{id}/edit", name="studentpromotion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StudentPromotion entity.');
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
    * Creates a form to edit a StudentPromotion entity.
    *
    * @param StudentPromotion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(StudentPromotion $entity)
    {
        $form = $this->createForm(new StudentPromotionType(), $entity, array(
            'action' => $this->generateUrl('studentpromotion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing StudentPromotion entity.
     *
     * @Route("/{id}", name="studentpromotion_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:StudentPromotion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StudentPromotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('studentpromotion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a StudentPromotion entity.
     *
     * @Route("/{id}", name="studentpromotion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
			$gsmode=null;
			$promotionId=null;
			parse_str(parse_url($this->get('request')->server->get('HTTP_REFERER'), PHP_URL_QUERY), $queries);
			if($queries != null)
			{
				if($queries['gsmode']!=null)
				{
					$gsmode=$queries['gsmode'];
				}
				
				if($queries['promotionId']!=null)
				{
					$promotionId=$queries['promotionId'];
				}
			}
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StudentPromotion entity.');
            }
			
			$myEntities = $em->getRepository('C2JEasySaisieBundle:Mark')->findBy(array('studentPromotion'=>$id));
			if($myEntities == null)
			{
				$gsmode=null;
				$formationId=null;
				parse_str(parse_url($this->get('request')->server->get('HTTP_REFERER'), PHP_URL_QUERY), $queries);
				if($queries != null)
				{
					if($queries['gsmode']!=null)
					{
						$gsmode=$queries['gsmode'];
					}
					
					if($queries['promotionId']!=null)
					{
						$promotionId=$queries['promotionId'];
					}
				}
				$em->remove($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'L\'étudiant a été supprimée de la promotion avec succès !'
				);
				
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('student_new').'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('studentpromotion'));
				}
			}
			else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'Cet étudiant possède une ou plusieurs notes !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('studentpromotion_edit', array('id' => $id)).'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('studentpromotion_edit', array('id' => $id)));
				} 
			}
        } 
    }

    /**
     * Creates a form to delete a StudentPromotion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('studentpromotion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
