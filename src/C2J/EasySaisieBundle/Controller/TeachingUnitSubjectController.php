<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\TeachingUnitSubject;
use C2J\EasySaisieBundle\Form\TeachingUnitSubjectType;

/**
 * TeachingUnitSubject controller.
 *
 * @Route("/teachingunitsubject")
 */
class TeachingUnitSubjectController extends Controller
{

    /**
     * Lists all TeachingUnitSubject entities.
     *
     * @Route("/", name="teachingunitsubject")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitSubject')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TeachingUnitSubject entity.
     *
     * @Route("/", name="teachingunitsubject_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:TeachingUnitSubject:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TeachingUnitSubject();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('teachingunitsubject_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a TeachingUnitSubject entity.
    *
    * @param TeachingUnitSubject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(TeachingUnitSubject $entity)
    {
        $form = $this->createForm(new TeachingUnitSubjectType(), $entity, array(
            'action' => $this->generateUrl('teachingunitsubject_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TeachingUnitSubject entity.
     *
     * @Route("/new", name="teachingunitsubject_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new TeachingUnitSubject();
		$request = Request::createFromGlobals();
		$request->getPathInfo();
		$teachingUnitId=$request->query->get('teachingUnitId');
		$subjectId=$request->query->get('subjectId');
        
		if($teachingUnitId != null) {  
			$em = $this->getDoctrine()->getManager();
			$entity2 = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->find($teachingUnitId);
			$entity->setTeachingUnit($entity2);
		}
		
		if($subjectId != null) {  
			$em = $this->getDoctrine()->getManager();
			$entity2 = $em->getRepository('C2JEasySaisieBundle:Subject')->find($subjectId);
			$entity->setSubject($entity2);
		}
		
		$form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TeachingUnitSubject entity.
     *
     * @Route("/{id}", name="teachingunitsubject_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitSubject')->find($id);
				
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitSubject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TeachingUnitSubject entity.
     *
     * @Route("/{id}/edit", name="teachingunitsubject_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitSubject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitSubject entity.');
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
    * Creates a form to edit a TeachingUnitSubject entity.
    *
    * @param TeachingUnitSubject $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TeachingUnitSubject $entity)
    {
        $form = $this->createForm(new TeachingUnitSubjectType(), $entity, array(
            'action' => $this->generateUrl('teachingunitsubject_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TeachingUnitSubject entity.
     *
     * @Route("/{id}", name="teachingunitsubject_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:TeachingUnitSubject:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitSubject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitSubject entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teachingunitsubject_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TeachingUnitSubject entity.
     *
     * @Route("/{id}", name="teachingunitsubject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:TeachingUnitSubject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TeachingUnitSubject entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teachingunitsubject'));
    }

    /**
     * Creates a form to delete a TeachingUnitSubject entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teachingunitsubject_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
