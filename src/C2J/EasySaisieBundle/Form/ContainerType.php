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
            ->add('name')
            ->add('promotion')
			->add('areTeachingUnitsCompensable', 'checkbox', array(
				'required'  => false))
			->add('minMark')
			->add('minAverage')
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
