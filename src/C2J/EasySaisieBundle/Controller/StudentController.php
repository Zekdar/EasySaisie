<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Student;
use C2J\EasySaisieBundle\Form\StudentType;
use C2J\EasySaisieBundle\Entity\StudentPromotion;
use C2J\EasySaisieBundle\Form\StudentPromotionType;

/**
 * Student controller.
 *
 * @Route("/student")
 */
class StudentController extends Controller
{

    /**
     * Lists all Student entities.
     *
     * @Route("/", name="student")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('C2JEasySaisieBundle:Student')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Student entity.
     *
     * @Route("/", name="student_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:Student:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Student();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {		
					
			$number=$entity->getNumber();	
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
			
			$em = $this->getDoctrine()->getManager();
			$student = $em->getRepository('C2JEasySaisieBundle:Student')->findOneByNumber($number);

			if($student == null) //if student doesn't exist
			{
				$student = new Student();
				$student->setNumber($number);
				$student->setLastName($lastName);
				$student->setFirstName($firstName);
				$em->persist($student);
				$em->flush();
			}
			
			if($promotionId != null)
			{				
				$studentId = $student->getId();
				$studentPromotion = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findBy(array('student' => $studentId, 'promotion' => $promotionId));
				if($studentPromotion == null) //if studentPromotion doesn't exist
				{
					$promotion = $em->getRepository('C2JEasySaisieBundle:Promotion')->find($promotionId);
				
					$entity = new StudentPromotion();
					$entity->setStudent($student);
					$entity->setPromotion($promotion);
					$em->persist($entity);
					$em->flush();

					$this->get('session')->getFlashBag()->add(
						'success',
						'L\'étudiant a été ajouté dans la promotion créé avec succès !'
					);
					if($gsmode)
					{
						return $this->redirect($this->generateUrl('student_new').'?gsmode=true&promotionId='.$promotionId);
					}			
					else
					{
						return $this->redirect($this->generateUrl('student_show', array('id' => $entity->getId())));
					}
				}
				else
				{
					$this->get('session')->getFlashBag()->add(
						'failure',
						'L\'étudiant existe déjà la promotion !'
					);
					if($gsmode)
					{
						return $this->redirect($this->generateUrl('student_new').'?gsmode=true&promotionId='.$promotionId);
					}
					else
					{
						return $this->redirect($this->generateUrl('student_new'));
					}
				}
			}
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Student entity.
    *
    * @param Student $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Student $entity)
    {
        $form = $this->createForm(new StudentType(), $entity, array(
            'action' => $this->generateUrl('student_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Student entity.
     *
     * @Route("/new", name="student_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Student();
        $form   = $this->createCreateForm($entity);
		$request = Request::createFromGlobals();
		$request->getPathInfo();
		$promotionId=$request->query->get('promotionId');
		
		$entities = null;
		
		if($promotionId != null) { 
			$em = $this->getDoctrine()->getManager();
			$entities = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findBy(array("promotion" => $promotionId));
		}

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Student entity.
     *
     * @Route("/{id}", name="student_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Student')->find($id);
		$entities = $em->getRepository('C2JEasySaisieBundle:StudentPromotion')->findBy(array('student' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
			'entities'      => $entities,
        );
    }

    /**
     * Displays a form to edit an existing Student entity.
     *
     * @Route("/{id}/edit", name="student_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Student')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
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
    * Creates a form to edit a Student entity.
    *
    * @param Student $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Student $entity)
    {
        $form = $this->createForm(new StudentType(), $entity, array(
            'action' => $this->generateUrl('student_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Student entity.
     *
     * @Route("/{id}", name="student_update")
     * @Method("PUT")
     * @Template("C2JEasySaisieBundle:Student:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('C2JEasySaisieBundle:Student')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Student entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('student_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Student entity.
     *
     * @Route("/{id}", name="student_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('C2JEasySaisieBundle:Student')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Student entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('student'));
    }

    /**
     * Creates a form to delete a Student entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('student_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
