<?php

namespace C2J\EasySaisieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PromotionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formation' , null, array('label' => 'Formation'))
			->add('name', 'text', array('label' => 'Nom de la promotion'))
			->add('minAverageToValidate', 'text', array('label' => 'Moyenne pour valider l\'année'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'C2J\EasySaisieBundle\Entity\Promotion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'c2j_easysaisiebundle_promotion';
    }
}
