<?php

namespace CO\ArticlesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            //->add('image')
            ->add('tags')								
            ->add('blog', 'textarea', array('attr'=>array('class'=>'editor'), 'required'=>false) )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CO\ArticlesBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'co_articlesbundle_articletype';
    }
}
