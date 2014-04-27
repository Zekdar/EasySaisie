<?php

namespace C2J\EasySaisieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContainerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder           
            ->add('promotion')
			->add('name', 'text', array('label' => 'Nom du bloc'))
			->add('isCompensable', 'checkbox', array(
				'required'  => false,
				'label' => 'Le conteneur est-il compensable ?'))
			->add('minMark', 'text', array('label' => 'Note minimale'))
			->add('minAverage', 'text', array('label' => 'Moyenne minimale'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'C2J\EasySaisieBundle\Entity\Container'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'c2j_easysaisiebundle_container';
    }
}
