<?php

namespace sano\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null, array(
                'attr'  => array('class' => 'span7'),
                'label' => 'Naslov novice'
            ))
            ->add('email',null, array(
                'attr'  => array('class' => 'span7'),
                'label' => 'Email'
            ))
            ->add('text', 'textarea', array(
                'attr'  => array('class' => 'span7', 'rows' => 15, 'cols'=>80),
                'label' => 'Novica'
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sano\CoreBundle\Entity\Comment'
        ));
    }

    public function getName()
    {
        return 'comment';
    }
}
