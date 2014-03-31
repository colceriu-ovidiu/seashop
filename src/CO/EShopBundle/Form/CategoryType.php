<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type', new CategoryTypeUI())
            ->add('parent', 'entity', array(
									'class' => 'COEShopBundle:Category',
									'query_builder' => function(EntityRepository $er) {
												return $er->getParentsQB();
											},
									'empty_value' => '-- none --',
									'required' => false
									)
								)
            ->add('metadescription')
            ->add('metakeywords')

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CO\EShopBundle\Entity\Category'
        ));
    }

    public function getName()
    {
        return 'co_eshopbundle_categorytype';
    }
}
