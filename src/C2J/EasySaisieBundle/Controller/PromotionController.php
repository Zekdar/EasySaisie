<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Promotion;
use C2J\EasySaisieBundle\Form\PromotionType;

/**
 * Promotion controller.
 *
 * @Route("/promotion")
 */
class PromotionController extends Controller
{

    /**
     * Lists all Promotion entities.
     *
     * @Route("/", name="promotion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('C2JEasySaisieBundle:Promotion')->findBy(array(), array('name' => 'asc'));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Promotion entity.
     *
     * @Route("/", name="promotion_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:Promotion:new.html.twig")
     */
    public function createAction(Request $request)
    {
		$entity = new Promotion();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
			$em = $this->getDoctrine()->getManager();
			
			$name=$entity->getName();
			$year=$entity->getYear();
			$formationId=$entity->getFormation()->getId();
			
			$gsmode=null;
			parse_str(parse_url($this->get('request')->server->get('HTTP_REFERER'), PHP_URL_QUERY), $queries);
			if($queries != null)
			{
				if($queries['gsmode']!=null)
				{
					$gsmode=$queries['gsmode'];
				}
			}

			$entity2 = $em->getRepository('C2JEasySaisieBundle:Promotion')->findOneBy(array('name' => $name, 'year' => $year, 'formation' => $formationId));
			if($entity2 == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'La promotion a été créée avec succès !'
				);
				if($gsmode)
				{
					$entity2 = $em->getRepository('C2JEasySaisieBundle:Promotion')->findOneBy(array('name' => $name, 'year' => $year, 'formation' => $formationId));
					$promotionId=$entity2->getId();
					return $this->redirect($this->generateUrl('container_new').'?gsmode=true&promotionId='.$promotionId);
				}			
				else
				{
					return $this->redirect($this->generateUrl('promotion_show', array('id' => $entity->getId())));
				}
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'La promotion existe déjà !'
				);
				if($gsmode)
				{					
					return $this->redirect($this->generateUrl('promotion_new').'?gsmode=true&formationId='.$formationId);
				}
				else
				{
					return $this->redirect($this->generateUrl('promotion_new'));
				}
			}  
        }
	
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Promotion entity.
    *
    * @param Promotion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Promotion $entity)
    {
        $form = $this->createForm(new PromotionType(), $entity, array(
            'action' => $this->generateUrl('promotion_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Promotion entity.
     *
     * @Route("/new", name="promotion_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
		$entity = new Promotion();
		$request = Request::createFromGlobals();
		$request->getPathInfo();
		$formationId=$request->query->get('formationId');
		
		$em = $this->getDoctrine()->getManager();
		$entities=null;
		
		if($formationId != null) {  
			$entities = $em->getRepository('C2JEasySaisieBundle:Promotion')->findBy(array("formation" => $formationId));
			$entity2 = $em->getRepository('C2JEasySaisieBundle:Formation')->find($formationId);
			$entity->setFormation($entity2);
		}
		
        $form   = $this->createCreateForm($entity);
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'entities' => $entities
        );
    }

    /**
     * Finds and displays a Promotion entity.
     *
     * @Route("/{id}", name="promotion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Promotion')->find($id);
		$entities = $em->getRepository('C2JEasySaisieBundle:Container')->findBy(array('promotion' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
			'entities' => $entities,
        );
    }

    /**
     * Displays a form to edit an existing Promotion entity.
     *
     * @Route("/{id}/edit", name="promotion_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
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
    * Creates a form to edit a Promotion entity.
    *
    * @param Promotion $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Promotion $entity)
    {
        $form = $this->createForm(new PromotionType(), $entity, array(
            'action' => $this->generateUrl('promotion_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Promotion entity.
     *
     * @Route("/{id}", name="promotion_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:Promotion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Promotion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Promotion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
			$gsmode=null;
			$formationId=null;
			parse_str(parse_url($this->get('request')->server->get('HTTP_REFERER'), PHP_URL_QUERY), $queries);
			if($queries != null)
			{
				if($queries['gsmode']!=null)
				{
					$gsmode=$queries['gsmode'];
				}
				
				if($queries['formationId']!=null)
				{
					$formationId=$queries['formationId'];
				}
			}
            $em->flush();
			
			$this->get('session')->getFlashBag()->add(
				'success',
				'La promotion a été mise à jour avec succès !'
			);
			
			if($gsmode)
			{
				return $this->redirect($this->generateUrl('promotion_new').'?gsmode=true&formationId='.$formationId);
			}			
			else
			{
				return $this->redirect($this->generateUrl('promotion_show', array('id' => $entity->getId())));
			}
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Promotion entity.
     *
     * @Route("/{id}", name="promotion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
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
				
				if($queries['formationId']!=null)
				{
					$formationId=$queries['formationId'];
				}
			}
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:Promotion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Promotion entity.');
            }
			
			$studentPromotions = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findBy(array('promotion'=>$id));
			$containers = $em->getRepository('C2JEasySaisieBundle:Container')->findBy(array('promotion'=>$id));
			if($studentPromotions==null && $containers==null)
			{
				$em->remove($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'La promotion a été supprimée avec succès !'
				);
				
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('promotion_new').'?gsmode=true&formationId='.$formationId);
				}
				else
				{
					return $this->redirect($this->generateUrl('promotion'));
				}
			}
			else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'Cette promotion est utilisée actuellement !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('promotion_edit', array('id' => $id)).'?gsmode=true&formationId='.$formationId);
				}
				else
				{
					return $this->redirect($this->generateUrl('promotion_edit', array('id' => $id)));
				} 
			}
        }
    }

    /**
     * Creates a form to delete a Promotion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promotion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
