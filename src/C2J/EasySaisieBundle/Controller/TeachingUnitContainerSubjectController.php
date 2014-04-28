<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject;
use C2J\EasySaisieBundle\Form\TeachingUnitContainerSubjectType;
use C2J\EasySaisieBundle\Entity\TeachingUnitContainer;
use C2J\EasySaisieBundle\Form\TeachingUnitContainerType;

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
			$teachingUnitId=$entity->getTeachingUnit()->getId();
			$containerId=$entity->getContainer()->getId();
			
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
			$entityTuc = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->findOneBy(array(
																							'teachingUnit' => $teachingUnitId, 
																							'container' => $containerId));
			if($entityTuc == null)
			{
				$entityContainer = $em->getRepository('C2JEasySaisieBundle:Container')->find($containerId);
				$entityTu = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->find($teachingUnitId);
				
				$entityTuc=new TeachingUnitContainer();
				$entityTuc->setTeachingUnit($entityTu);
				$entityTuc->setContainer($entityContainer);				
				$em->persist($entityTuc);
				$em->flush();
			}
			$entitySubject=$entity->getSubject();
			$entityTeacher=$entity->getTeacher();
			
			$entity->setTeachingUnitContainer($entityTuc);
			$entity->setSubject($entitySubject);
			if($entityTeacher != null)
			{
				$entity->setTeacher($entityTeacher);
			}
			$em->persist($entity);
			$em->flush();
			$this->get('session')->getFlashBag()->add(
					'success',
					'La matière a été affectée à la promotion !'
			);
			
			if($gsmode)
			{
				return $this->redirect($this->generateUrl('teachingunitcontainersubject_new').'?gsmode=true&promotionId='.$promotionId);
			}			
			else
			{
				return $this->redirect($this->generateUrl('teachingunitcontainersubject_show', array('id' => $entity->getId())));
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
		$promotionId=$request->query->get('promotionId');
		
		$entities = null;
		
		if($promotionId != null) { 
			$em = $this->getDoctrine()->getManager();
			$entities = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainerSubject')->findAllTucsByPromotionId($promotionId);
		}
			
		$form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'entities' => $entities,
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
	
		$containerId = $entity->getTeachingUnitContainer()->getContainer()->getId();
		$container = $em->getRepository('C2JEasySaisieBundle:Container')->find($containerId);
		
		var_dump($entity->getTeachingUnitContainer());
		exit;
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TeachingUnitContainerSubject entity.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
		
        return array(
            'entity'      => $entity,
			'container'	  => $container,
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
			$teachingUnitId=$entity->getTeachingUnit()->getId();
			$containerId=$entity->getContainer()->getId();
	
			$em = $this->getDoctrine()->getManager();		
			$entityTuc = $em->getRepository('C2JEasySaisieBundle:TeachingUnitContainer')->findOneBy(array(
																							'teachingUnit' => $teachingUnitId, 
																							'container' => $containerId));
			if($entityTuc == null)
			{
				$entityContainer = $em->getRepository('C2JEasySaisieBundle:Container')->find($containerId);
				$entityTu = $em->getRepository('C2JEasySaisieBundle:TeachingUnit')->find($teachingUnitId);
				
				$entityTuc=new TeachingUnitContainer();
				$entityTuc->setTeachingUnit($entityTu);
				$entityTuc->setContainer($entityContainer);				
				$em->persist($entityTuc);
				$em->flush();
			}
			$entitySubject=$entity->getSubject();
			$entityTeacher=$entity->getTeacher();
			
			$entity->setTeachingUnitContainer($entityTuc);
			$entity->setSubject($entitySubject);
			if($entityTeacher != null)
			{
				$entity->setTeacher($entityTeacher);
			}
			$em->persist($entity);
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
