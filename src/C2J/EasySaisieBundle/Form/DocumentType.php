<?php

namespace C2J\EasySaisieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DocumentType extends AbstractType
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
            ->add('file', 'file', array('label' => 'Fichier .xls'))
			->add('promotion', 'entity', array(
				'empty_value' => "Choisir une promotion",
				'class' => 'C2J\EasySaisieBundle\Entity\Promotion',
				'property' => 'name',
				'query_builder' => function(EntityRepository $er) use ($promotionId)
					{    
						return $er->getPromotions( $promotionId ); },
				'label' => 'Promotion',
				'required' => false
			))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'C2J\EasySaisieBundle\Entity\Document'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'c2j_easysaisiebundle_document';
    }
}
