<?php

namespace C2J\EasySaisieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeachingUnitType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom de l\'UE'))
            ->add('code', 'text', array('label' => 'Code UE'))
			->add('isCompensable', 'checkbox', array(
				'required'  => false,
				'label'		=> 'L\'UE est-elle compensable ?'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'C2J\EasySaisieBundle\Entity\TeachingUnit'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'c2j_easysaisiebundle_teachingunit';
    }
}
