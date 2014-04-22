<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use C2J\EasySaisieBundle\Entity\Document;
use C2J\EasySaisieBundle\Entity\Student;
use C2J\EasySaisieBundle\Entity\StudentPromotion;
use C2J\EasySaisieBundle\Form\DocumentType;
use C2J\EasySaisieBundle\Form\StudentType;
use C2J\EasySaisieBundle\Form\StudentPromotionType;


/**
 * Document controller.
 *
 * @Route("/document")
 */
class DocumentController extends Controller
{
    /**
     * Creates a new Document entity.
     *
     * @Route("/", name="document_create")
     * @Method("POST")
     * @Template("C2JEasySaisieBundle:Document:new.html.twig")
     */
    public function createAction(Request $request)
    {
		$entity = new Document();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
		
        if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity->upload();
			$inputFileName=$entity->getAbsolutePath();
			
			$promotionId=null;
			if($entity->getPromotion()!=null)
			{
				$promotionId=$entity->getPromotion()->getId();
			}
		
			$objPHPExcel = \PHPExcel_IOFactory::load($inputFileName);
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow(); 
			$highestColumn = "C"; // C column
			
			for ($row = 1; $row <= $highestRow; $row++){ 
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
												
				$number=trim($rowData[0][0]);
				$lastName=trim(strtoupper($rowData[0][1]));
				$firstName=trim(strtolower(ucwords($rowData[0][2])));
				$em = $this->getDoctrine()->getManager();
				$student = $em->getRepository('C2JEasySaisieBundle:Student')->findOneByNumber($number);
				
				if($student == null) //if student doesn't exist
				{
					$entity = new Student();
					$entity->setNumber($number);
					$entity->setLastName($lastName);
					$entity->setFirstName($firstName);
					$em->persist($entity);
					$em->flush();
				}
				
				if($promotionId != null)
				{					
					if($student != null) //if student exists
					{
						$promotion = $em->getRepository('C2JEasySaisieBundle:Promotion')->find($promotionId);
					
						$entity = new StudentPromotion();
						$entity->setStudent($student);
						$entity->setPromotion($promotion);
						$entity->setYear(2014);
						$em->persist($entity);
						$em->flush();
					}
				}
			}
		}
		return $this->redirect($this->generateUrl('student'));
    }
	
    /**
    * Creates a form to create a Document entity.
    *
    * @param Document $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Document $entity)
    {
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Importer'));

        return $form;
    }

    /**
     * Displays a form to create a new Document entity.
     *
     * @Route("/new", name="document_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Document();
        $form   = $this->createCreateForm($entity);
				
		$em = $this->getDoctrine()->getManager();
		$promotion = $em->getRepository('C2JEasySaisieBundle:Promotion')->findAll();
	
        return array(
            'entity' 	=> $entity,
            'form'   	=> $form->createView(),
        );
    }
}