<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Subject;
use C2J\EasySaisieBundle\Form\SubjectType;

/**
 * Subject controller.
 *
 * @Route("/subject")
 */
class SubjectController extends Controller
{

    /**
     * Lists all Subject entities.
     *
     * @Route("/", name="subject")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:Subject')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Subject entity.
     *
     * @Route("/", name="subject_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:Subject:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Subject();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
			$em = $this->getDoctrine()->getManager();
			
			$name=$entity->getName();
			$abbreviation=$entity->getAbbreviation();

			$checkName = $em->getRepository('C2JEasySaisieBundle:Subject')->findByName($name);
			$checkAbbreviation = $em->getRepository('C2JEasySaisieBundle:Subject')->findByAbbreviation($abbreviation);
			
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
			
			if($checkName == null && $checkAbbreviation == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'La matière a été créée avec succès !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('subject_new').'?gsmode=true&promotionId='.$promotionId);
				}			
				else
				{
					return $this->redirect($this->generateUrl('subject_show', array('id' => $entity->getId())));
				}		
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'La matière existe déjà !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('subject_new').'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('subject_new'));
				}			
			}  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Subject entity.
    *
    * @param Subject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Subject $entity)
    {
        $form = $this->createForm(new SubjectType(), $entity, array(
            'action' => $this->generateUrl('subject_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Subject entity.
     *
     * @Route("/new", name="subject_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Subject();
        $form   = $this->createCreateForm($entity);
		
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('C2JEasySaisieBundle:Subject')->findAll();

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Subject entity.
     *
     * @Route("/{id}", name="subject_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Subject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Subject entity.
     *
     * @Route("/{id}/edit", name="subject_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Subject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
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
    * Creates a form to edit a Subject entity.
    *
    * @param Subject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Subject $entity)
    {
        $form = $this->createForm(new SubjectType(), $entity, array(
            'action' => $this->generateUrl('subject_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Subject entity.
     *
     * @Route("/{id}", name="subject_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:Subject:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Subject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Subject entity.');
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
					'La matière a été mise à jour avec succès !'
			);
			if($gsmode)
			{
				return $this->redirect($this->generateUrl('subject_new').'?gsmode=true&promotionId='.$promotionId);
			}			
			else
			{
				return $this->redirect($this->generateUrl('subject_edit', array('id' => $id)));
			}	
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Subject entity.
     *
     * @Route("/{id}", name="subject_delete")
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
            $entity = $em->getRepository('C2JEasySaisieBundle:Subject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Subject entity.');
            }
			$myEntities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->findBy(array('subject'=>$id));
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
					'La matière a été supprimée avec succès !'
				);
				
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('subject_new').'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('subject'));
				}
			}
			else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'Cette matière est utilisée actuellement !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('subject_edit', array('id' => $id)).'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('subject_edit', array('id' => $id)));
				} 
			}
        } 
    }

    /**
     * Creates a form to delete a Subject entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subject_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
