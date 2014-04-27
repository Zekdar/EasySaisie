<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\TeachingUnitContainer;
use C2J\EasySaisieBundle\Form\TeachingUnitContainerType;

/**
 * TeachingUnitContainer controller.
 *
 * @Route("/teachingunitcontainer")
 */
class TeachingUnitContainerController extends Controller
{

    /**
     * Lists all TeachingUnitContainer entities.
     *
     * @Route("/", name="teachingunitcontainer")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TeachingUnitContainer entity.
     *
     * @Route("/", name="teachingunitcontainer_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:TeachingUnitContainer:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TeachingUnitContainer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
			$em = $this->getDoctrine()->getManager();
			
			$name=$entity->getName();
			$code=$entity->getCode();
			$containerId=$entity->getContainer()->getId();
			
			$entity2 = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->findBy(array('name' => $name, 'code' => $code, 'container' => $containerId));
			
			if($entity2 == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'L\'UE a été créée avec succès !'
				);
				return $this->redirect($this->generateUrl('teachingunitcontainer_show', array('id' => $entity->getId())));
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'L\'UE existe déjà !'
				);
				return $this->redirect($this->generateUrl('teachingunitcontainer_new'));
			}  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a TeachingUnitContainer entity.
    *
    * @param TeachingUnitContainer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TeachingUnitContainer $entity)
    {
        $form = $this->createForm(new TeachingUnitContainerType(), $entity, array(
            'action' => $this->generateUrl('teachingunitcontainer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TeachingUnitContainer entity.
     *
     * @Route("/new", name="teachingunitcontainer_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TeachingUnitContainer();
		$request = Request::createFromGlobals();
		$request->getPathInfo();
		$id=$request->query->get('id');
		
		if($id != null) {  
			$em = $this->getDoctrine()->getManager();
			$entity2 = $em->getRepository('C2JEasySaisieBundle:Container')->find($id);
			$entity->setContainer($entity2);
		}
		
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TeachingUnitContainer entity.
     *
     * @Route("/{id}", name="teachingunitcontainer_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->find($id);
		$entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->findBy(array('teachingUnitContainer' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitContainer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
			'entities'      => $entities,
        );
    }

    /**
     * Displays a form to edit an existing TeachingUnitContainer entity.
     *
     * @Route("/{id}/edit", name="teachingunitcontainer_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitContainer entity.');
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
    * Creates a form to edit a TeachingUnitContainer entity.
    *
    * @param TeachingUnitContainer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TeachingUnitContainer $entity)
    {
        $form = $this->createForm(new TeachingUnitContainerType(), $entity, array(
            'action' => $this->generateUrl('teachingunitcontainer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TeachingUnitContainer entity.
     *
     * @Route("/{id}", name="teachingunitcontainer_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:TeachingUnitContainer:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitContainer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teachingunitcontainer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TeachingUnitContainer entity.
     *
     * @Route("/{id}", name="teachingunitcontainer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TeachingUnitContainer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teachingunitcontainer'));
    }

    /**
     * Creates a form to delete a TeachingUnitContainer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teachingunitcontainer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
