<?php

namespace C2J\EasySaisieBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudentPromotionMarksType extends StudentPromotionType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->remove('student')
            ->remove('promotion')
            ->add('marks','collection',array('type' => new MarkType()))
        ;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'c2j_easysaisiebundle_studentpromotionmark';
    }
}
