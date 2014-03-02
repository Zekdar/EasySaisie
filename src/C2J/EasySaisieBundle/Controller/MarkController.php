<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Mark;
use C2J\EasySaisieBundle\Form\MarkType;

/**
 * Mark controller.
 *
 * @Route("/mark")
 */
class MarkController extends Controller
{

    /**
     * Lists all promotion by year.
     *
     * @Route("/", name="mark")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findAllPromotionsByYearDistinct();
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all marks for every students from a promotion for the specified year.
     *
     * @Route("/list/{year}/{promotion_id}", name="mark_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction($year, $promotion_id) 
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('C2JEasySaisieBundle:Student')->findAllMarksByStudentsByPromotion($promotion_id, $year);
        Doctrine\Common\Util\Debug\dump($entities);exit;
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Mark entity.
     *
     * @Route("/", name="mark_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:Mark:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Mark();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mark_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Mark entity.
    *
    * @param Mark $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Mark $entity)
    {
        $form = $this->createForm(new MarkType(), $entity, array(
            'action' => $this->generateUrl('mark_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Mark entity.
     *
     * @Route("/new", name="mark_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mark();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Mark entity.
     *
     * @Route("/{id}", name="mark_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mark entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Mark entity.
     *
     * @Route("/{id}/edit", name="mark_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mark entity.');
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
    * Creates a form to edit a Mark entity.
    *
    * @param Mark $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mark $entity)
    {
        $form = $this->createForm(new MarkType(), $entity, array(
            'action' => $this->generateUrl('mark_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Mark entity.
     *
     * @Route("/{id}", name="mark_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:Mark:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mark entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mark_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Mark entity.
     *
     * @Route("/{id}", name="mark_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:Mark')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mark entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mark'));
    }

    /**
     * Creates a form to delete a Mark entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mark_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
