<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject;
use C2J\EasySaisieBundle\Form\TeachingUnitContainerSubjectType;

/**
 * TeachingUnitContainerSubject controller.
 *
 * @Route("/teachingunitcontainersubject")
 */
class TeachingUnitContainerSubjectController extends Controller
{

    /**
     * Lists all TeachingUnitContainerSubject entities.
     *
     * @Route("/", name="teachingunitcontainersubject")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TeachingUnitContainerSubject entity.
     *
     * @Route("/", name="teachingunitcontainersubject_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:TeachingUnitContainerSubject:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TeachingUnitContainerSubject();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
			$em = $this->getDoctrine()->getManager();
			
			$teachingUnitContainerId=$entity->getTeachingUnitContainer()->getId();
			$subjectId=$entity->getSubject()->getId();
			
			$entity2 = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->findBy(array('teachingUnitContainer' => $teachingUnitContainerId, 'subject' => $subjectId));
			
			if($entity2 == null)
			{
				$em->persist($entity);
				$em->flush();
				$this->get('session')->getFlashBag()->add(
					'success',
					'La matière a été ajoutée dans l\'UE avec succès !'
				);
				return $this->redirect($this->generateUrl('teachingunitcontainersubject_show', array('id' => $entity->getId())));
			}			
            else
			{
				$this->get('session')->getFlashBag()->add(
					'failure',
					'La matière existe déjà dans l\'UE !'
				);
				return $this->redirect($this->generateUrl('teachingunitcontainersubject_new'));
			}  
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a TeachingUnitContainerSubject entity.
    *
    * @param TeachingUnitContainerSubject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TeachingUnitContainerSubject $entity)
    {
        $form = $this->createForm(new TeachingUnitContainerSubjectType(), $entity, array(
            'action' => $this->generateUrl('teachingunitcontainersubject_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TeachingUnitContainerSubject entity.
     *
     * @Route("/new", name="teachingunitcontainersubject_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TeachingUnitContainerSubject();
		$request = Request::createFromGlobals();
		$request->getPathInfo();
		$teachingUnitContainerId=$request->query->get('teachingUnitContainerId');
		$subjectId=$request->query->get('subjectId');
        
		if($teachingUnitContainerId != null) {  
			$em = $this->getDoctrine()->getManager();
			$entity2 = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->find($teachingUnitContainerId);
			$entity->setTeachingUnitContainer($entity2);
		}
		
		if($subjectId != null) {  
			$em = $this->getDoctrine()->getManager();
			$entity2 = $em->getRepository('C2JEasySaisieBundle:Subject')->find($subjectId);
			$entity->setSubject($entity2);
		}
		
		$em = $this->getDoctrine()->getManager();
		$container = $em->getRepository('C2JEasySaisieBundle:Container')->findAll();
		
		$form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TeachingUnitContainerSubject entity.
     *
     * @Route("/{id}", name="teachingunitcontainersubject_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->find($id);
				
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitContainerSubject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TeachingUnitContainerSubject entity.
     *
     * @Route("/{id}/edit", name="teachingunitcontainersubject_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitContainerSubject entity.');
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
    * Creates a form to edit a TeachingUnitContainerSubject entity.
    *
    * @param TeachingUnitContainerSubject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TeachingUnitContainerSubject $entity)
    {
        $form = $this->createForm(new TeachingUnitContainerSubjectType(), $entity, array(
            'action' => $this->generateUrl('teachingunitcontainersubject_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TeachingUnitContainerSubject entity.
     *
     * @Route("/{id}", name="teachingunitcontainersubject_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:TeachingUnitContainerSubject:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitContainerSubject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teachingunitcontainersubject_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TeachingUnitContainerSubject entity.
     *
     * @Route("/{id}", name="teachingunitcontainersubject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TeachingUnitContainerSubject entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teachingunitcontainersubject'));
    }

    /**
     * Creates a form to delete a TeachingUnitContainerSubject entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teachingunitcontainersubject_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
