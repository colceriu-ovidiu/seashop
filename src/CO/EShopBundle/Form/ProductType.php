<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', array(
							'class' => 'COEShopBundle:Category',
							'property' => 'name',
							'group_by' => 'parent.name',
							'query_builder' => function(EntityRepository $er) {
												return $er->createQueryBuilder('c')
														->orderBy('c.name')
														->orderBy('c.name', 'ASC')
														->where('c.parent IS NOT NULL')
														;
												},
						))
            /*->add('category')*/
            ->add('name')
            ->add('price')
            ->add('shortdesc')
            ->add('description')
            ->add('um')
            ->add('available')
            ->add('metadescription')
            ->add('metakeywords')
			->add('discount')
            ->add('pic_file')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CO\EShopBundle\Entity\Product'
        ));
    }

    public function getName()
    {
        return 'co_eshopbundle_producttype';
    }
}
