<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            'data_class' => 'CO\EShopBundle\Entity\Promo'
        ));
    }

    public function getName()
    {
        return 'co_eshopbundle_promotype';
    }

}
