<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\TeachingUnit;
use C2J\EasySaisieBundle\Form\TeachingUnitType;

/**
 * TeachingUnit controller.
 *
 * @Route("/teachingunit")
 */
class TeachingUnitController extends Controller
{

    /**
     * Lists all TeachingUnit entities.
     *
     * @Route("/", name="teachingunit")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TeachingUnit entity.
     *
     * @Route("/", name="teachingunit_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:TeachingUnit:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TeachingUnit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
			$em = $this->getDoctrine()->getManager();
			
			$name=$entity->getName();
			$code=$entity->getCode();
					
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
				
			$entity2 = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->findBy(array('name' => $name, 'code' => $code));
			
			if($entity2 == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'L\'UE a été créée avec succès !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('teachingunit_new').'?gsmode=true&promotionId='.$promotionId);
				}			
				else
				{
					return $this->redirect($this->generateUrl('teachingunit_show', array('id' => $entity->getId())));
				}			
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'L\'UE existe déjà !'
				);
				if($gsmode)
				{
					return $this->redirect($this->generateUrl('teachingunit_new').'?gsmode=true&promotionId='.$promotionId);
				}
				else
				{
					return $this->redirect($this->generateUrl('teachingunit_new'));
				}				
			}  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a TeachingUnit entity.
    *
    * @param TeachingUnit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TeachingUnit $entity)
    {
        $form = $this->createForm(new TeachingUnitType(), $entity, array(
            'action' => $this->generateUrl('teachingunit_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TeachingUnit entity.
     *
     * @Route("/new", name="teachingunit_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TeachingUnit();
		$request = Request::createFromGlobals();
		$request->getPathInfo();
		$id=$request->query->get('id');
		
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->findAll();
				
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'entities' => $entities,
        );
    }

    /**
     * Finds and displays a TeachingUnit entity.
     *
     * @Route("/{id}", name="teachingunit_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->find($id);
		$entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitSubject')->findBy(array('teachingUnit' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
			'entities'      => $entities,
        );
    }

    /**
     * Displays a form to edit an existing TeachingUnit entity.
     *
     * @Route("/{id}/edit", name="teachingunit_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnit entity.');
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
    * Creates a form to edit a TeachingUnit entity.
    *
    * @param TeachingUnit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TeachingUnit $entity)
    {
        $form = $this->createForm(new TeachingUnitType(), $entity, array(
            'action' => $this->generateUrl('teachingunit_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TeachingUnit entity.
     *
     * @Route("/{id}", name="teachingunit_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:TeachingUnit:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teachingunit_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TeachingUnit entity.
     *
     * @Route("/{id}", name="teachingunit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TeachingUnit entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teachingunit'));
    }

    /**
     * Creates a form to delete a TeachingUnit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teachingunit_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
