<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class BannerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('pic_file')
            ->add('product', 'entity', array(
									'class' => 'COEShopBundle:Product',
									'query_builder' => function(EntityRepository $er) {
												return $er->getProductsQB();
											},
									'required' => true,
									'attr'   =>  array('class'   => 'product_down')
									)
								)
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CO\EShopBundle\Entity\Banner'
        ));
    }

    public function getName()
    {
        return 'co_eshopbundle_bannertype';
    }

}
