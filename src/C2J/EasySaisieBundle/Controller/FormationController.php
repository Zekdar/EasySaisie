<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Formation;
use C2J\EasySaisieBundle\Form\FormationType;

/**
 * Formation controller.
 *
 * @Route("/formation")
 */
class FormationController extends Controller
{

    /**
     * Lists all Formation entities.
     *
     * @Route("/", name="formation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:Formation')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Formation entity.
     *
     * @Route("/", name="formation_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:Formation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Formation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
		
        if ($form->isValid()) {		
			$gsmode=null;
			parse_str(parse_url($this->get('request')->server->get('HTTP_REFERER'), PHP_URL_QUERY), $queries);
			if($queries != null)
			{
				if($queries['gsmode']!=null)
				{
					$gsmode=$queries['gsmode'];
				}
			}
			
			$em = $this->getDoctrine()->getManager();
			
			$name=$entity->getName();
			$type=$entity->getType();
			
			$entity2 = $em->getRepository('C2JEasySaisieBundle:Formation')->findOneBy(array('name' => $name, 'type' => $type));
			
			if($entity2 == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'La formation a été créée avec succès !'
				);
				
				if($gsmode)
				{
					$entity2 = $em->getRepository('C2JEasySaisieBundle:Formation')->findOneBy(array('name' => $name, 'type' => $type));
					$formationId=$entity2->getId();
					return $this->redirect($this->generateUrl('promotion_new').'?gsmode=true&formationId='.$formationId);
				}
				else
				{
					return $this->redirect($this->generateUrl('formation_show', array('id' => $entity->getId())));
				}
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'La formation existe déjà !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('formation_new').'?gsmode=true');
				}
				else
				{
					return $this->redirect($this->generateUrl('formation_new'));
				}
			}  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Formation entity.
    *
    * @param Formation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Formation $entity)
    {
        $form = $this->createForm(new FormationType(), $entity, array(
            'action' => $this->generateUrl('formation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Formation entity.
     *
     * @Route("/new", name="formation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Formation();
        $form   = $this->createCreateForm($entity);
		
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('C2JEasySaisieBundle:Formation')->findAll();

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Formation entity.
     *
     * @Route("/{id}", name="formation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Formation')->find($id);
		$entities = $em->getRepository('C2JEasySaisieBundle:Promotion')->findBy(array('formation' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
			'entities' => $entities,
        );
    }

    /**
     * Displays a form to edit an existing Formation entity.
     *
     * @Route("/{id}/edit", name="formation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Formation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formation entity.');
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
    * Creates a form to edit a Formation entity.
    *
    * @param Formation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Formation $entity)
    {
        $form = $this->createForm(new FormationType(), $entity, array(
            'action' => $this->generateUrl('formation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Formation entity.
     *
     * @Route("/{id}", name="formation_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:Formation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Formation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Formation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
			$gsmode=null;
			parse_str(parse_url($this->get('request')->server->get('HTTP_REFERER'), PHP_URL_QUERY), $queries);
			if($queries != null)
			{
				if($queries['gsmode']!=null)
				{
					$gsmode=$queries['gsmode'];
				}
			}
            $em->flush();
			
			$em->persist($entity);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
				'success',
				'La formation a été mise à jour avec succès !'
			);
			
			if($gsmode)
			{
				return $this->redirect($this->generateUrl('formation_new').'?gsmode=true');
			}
			else
			{
				return $this->redirect($this->generateUrl('formation_edit', array('id' => $id)));
			}    
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Formation entity.
     *
     * @Route("/{id}", name="formation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:Formation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Formation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('formation'));
    }

    /**
     * Creates a form to delete a Formation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('formation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
