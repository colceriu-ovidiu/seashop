<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content', 'textarea', array('attr'=>array('class'=>'editor'), 'required'=>false) )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CO\EShopBundle\Entity\Newsletter'
        ));
    }

    public function getName()
    {
        return 'co_eshopbundle_newslettertype';
    }
}
