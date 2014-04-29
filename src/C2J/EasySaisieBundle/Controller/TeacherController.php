<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Teacher;
use C2J\EasySaisieBundle\Form\TeacherType;

/**
 * Teacher controller.
 *
 * @Route("/teacher")
 */
class TeacherController extends Controller
{

    /**
     * Lists all Teacher entities.
     *
     * @Route("/", name="teacher")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:Teacher')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Teacher entity.
     *
     * @Route("/", name="teacher_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:Teacher:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Teacher();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
			$em = $this->getDoctrine()->getManager();
			
			$lastName=$entity->getLastName();
			$firstName=$entity->getFirstName();
			
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

			$entity2 = $em->getRepository('C2JEasySaisieBundle:Teacher')->findBy(array('lastName' => $lastName, 'firstName' => $firstName));
			
			if($entity2 == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'Le professeur a été créé avec succès !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('teacher_new').'?gsmode=true&promotionId='.$promotionId);
				}			
				else
				{
					return $this->redirect($this->generateUrl('teacher_show', array('id' => $entity->getId())));
				}			
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'Le professeur existe déjà !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('teacher_new').'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('teacher_new'));
				}				
			}  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Teacher entity.
    *
    * @param Teacher $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Teacher $entity)
    {
        $form = $this->createForm(new TeacherType(), $entity, array(
            'action' => $this->generateUrl('teacher_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Teacher entity.
     *
     * @Route("/new", name="teacher_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Teacher();
        $form   = $this->createCreateForm($entity);
		
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('C2JEasySaisieBundle:Teacher')->findAll();

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Teacher entity.
     *
     * @Route("/{id}", name="teacher_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Teacher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Teacher entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Teacher entity.
     *
     * @Route("/{id}/edit", name="teacher_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Teacher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Teacher entity.');
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
    * Creates a form to edit a Teacher entity.
    *
    * @param Teacher $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Teacher $entity)
    {
        $form = $this->createForm(new TeacherType(), $entity, array(
            'action' => $this->generateUrl('teacher_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Teacher entity.
     *
     * @Route("/{id}", name="teacher_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:Teacher:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Teacher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Teacher entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
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
            $em->flush();
			$this->get('session')->getFlashBag()->add(
					'success',
					'Le professeur a été mis à jour avec succès !'
			);
			if($gsmode)
			{
				return $this->redirect($this->generateUrl('teacher_new').'?gsmode=true&promotionId='.$promotionId);
			}			
			else
			{
				return $this->redirect($this->generateUrl('teacher_edit', array('id' => $id)));
			} 
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Teacher entity.
     *
     * @Route("/{id}", name="teacher_delete")
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
            $entity = $em->getRepository('C2JEasySaisieBundle:Teacher')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Teacher entity.');
            }

            $em->remove($entity);
            $em->flush();
			$this->get('session')->getFlashBag()->add(
					'success',
					'Le professeur a été supprimé avec succès !'
			);
			if($gsmode)
			{
				return $this->redirect($this->generateUrl('teacher_new').'?gsmode=true&promotionId='.$promotionId);
			}			
			else
			{
				return $this->redirect($this->generateUrl('teacher'));
			}
        }
    }

    /**
     * Creates a form to delete a Teacher entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teacher_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
