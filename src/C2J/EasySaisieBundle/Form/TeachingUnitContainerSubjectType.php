<?php

namespace C2J\EasySaisieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class TeachingUnitContainerSubjectType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$promotionId=null;
		if(isset($_GET['promotionId']))
		{
			$promotionId=$_GET['promotionId'];
		}
        $builder
			->add('subject', null, array(
				'label' => 'Matière',
				'required' => true))
            ->add('coeff', 'text', array('label' => 'Coefficient'))
			->add('ects', 'text', array('label' => 'Nombre d\'ECTS'))
            ->add('teachingUnit', 'entity', array(
				'class' => 'C2J\EasySaisieBundle\Entity\TeachingUnit',
				'label' => 'UE'
			))
			->add('teacher', null, array('label' => 'Professeur'))
			->add('container', 'entity', array(
				'class' => 'C2J\EasySaisieBundle\Entity\Container',
				'query_builder' => function(EntityRepository $er) use ($promotionId)
					{    
						return $er->getContainers( $promotionId ); },
				'label' => 'Conteneur'))
		;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'C2J\EasySaisieBundle\Entity\TeachingUnitContainerSubject'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'c2j_easysaisiebundle_teachingunitcontainersubject';
    }
}
