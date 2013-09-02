<?php

namespace sano\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionnaireType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null, array(
                'attr'  => array('class' => 'span7'),
                'label' => 'Ime'
            ))             
            ->add('surname', null, array(
                'attr'  => array('class' => 'span7'),
                'label' => 'Priimek'
            ))             
            ->add('email', null, array(
                'attr'  => array('class' => 'span7'),
                'label' => 'email'
            ))
            ->add('date_of_birth', 'date', array(
                'attr'  => array('class' => 'span2'),
                'label' => 'Datum rojstva',
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy'
            ))
            ->add('browser', 'choice', array(
                'choices'   => array(
                'empty_value' => false,
                'Safari'   => 'Safari',
                'Mozilla' => 'Mozilla',
                'Opera'   => 'Opera',
                'Internet explorer'   => 'Internet explorer',
                'Chrome'   => 'Chrome',
                )
            ))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sano\CoreBundle\Entity\Questionnaire'
        ));
    }

    public function getName()
    {
        return 'questionnaire';
    }
}
