<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Container;
use C2J\EasySaisieBundle\Form\ContainerType;

/**
 * Container controller.
 *
 * @Route("/container")
 */
class ContainerController extends Controller
{

    /**
     * Lists all Container entities.
     *
     * @Route("/", name="container")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:Container')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Container entity.
     *
     * @Route("/", name="container_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:Container:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Container();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
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
					$formationId=$queries['promotionId'];
				}
			}
			$em = $this->getDoctrine()->getManager();
			
			$name=$entity->getName();
			$promotionId=$entity->getPromotion()->getId();
			
			$gsmode=null;
			parse_str(parse_url($this->get('request')->server->get('HTTP_REFERER'), PHP_URL_QUERY), $queries);
			if($queries != null)
			{
				if($queries['gsmode']!=null)
				{
					$gsmode=$queries['gsmode'];
				}
			}

			$entity2 = $em->getRepository('C2JEasySaisieBundle:Container')->findOneBy(array('name' => $name, 'promotion' => $promotionId));
			
			if($entity2 == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'Le conteneur a été créé avec succès !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('container_new').'?gsmode=true&promotionId='.$promotionId);
				}			
				else
				{
					return $this->redirect($this->generateUrl('container_show', array('id' => $entity->getId())));
				}
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'Le conteneur existe déjà !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('container_new').'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('container_new'));
				}				
			}  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Container entity.
    *
    * @param Container $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Container $entity)
    {
        $form = $this->createForm(new ContainerType(), $entity, array(
            'action' => $this->generateUrl('container_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Container entity.
     *
     * @Route("/new", name="container_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Container();
		$request = Request::createFromGlobals();
		$request->getPathInfo();
		$promotionId=$request->query->get('promotionId');
		
		$em = $this->getDoctrine()->getManager();
		$entities = null;
			
		if($promotionId != null) {  
			$em = $this->getDoctrine()->getManager();
			$entities = $em->getRepository('C2JEasySaisieBundle:Container')->findBy(array('promotion' => $promotionId));
			$entity2 = $em->getRepository('C2JEasySaisieBundle:Promotion')->find($promotionId);
			$entity->setPromotion($entity2);
		}
		
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Container entity.
     *
     * @Route("/{id}", name="container_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();		
        $entity = $em->getRepository('C2JEasySaisieBundle:Container')->find($id);
		$entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->findBy(array('container' => $id));
		
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Container entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
			'entities'	  => $entities,
        );
    }

    /**
     * Displays a form to edit an existing Container entity.
     *
     * @Route("/{id}/edit", name="container_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Container')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Container entity.');
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
    * Creates a form to edit a Container entity.
    *
    * @param Container $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Container $entity)
    {
        $form = $this->createForm(new ContainerType(), $entity, array(
            'action' => $this->generateUrl('container_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Container entity.
     *
     * @Route("/{id}", name="container_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:Container:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Container')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Container entity.');
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
					'Le conteneur a été mis à jour avec succès !'
			);
			if($gsmode)
			{
				return $this->redirect($this->generateUrl('container_new').'?gsmode=true&promotionId='.$promotionId);
			}			
			else
			{
				return $this->redirect($this->generateUrl('container_edit', array('id' => $id)));
			}
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Container entity.
     *
     * @Route("/{id}", name="container_delete")
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
            $entity = $em->getRepository('C2JEasySaisieBundle:Container')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Container entity.');
            }
			
			$myEntities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->findBy(array('container'=>$id));
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
					'Le conteneur a été supprimé avec succès !'
				);
				
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('container_new').'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('container'));
				}
			}
			else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'Ce conteneur est utilisé actuellement !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('container_edit', array('id' => $id)).'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('container_edit', array('id' => $id)));
				} 
			}
        }
    }

    /**
     * Creates a form to delete a Container entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('container_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
