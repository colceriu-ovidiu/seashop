<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DiscountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('name')
			->add('apply_type', new DiscountTypeUI())
			->add('percent')
			->add('sum')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CO\EShopBundle\Entity\Discount'
        ));
    }

    public function getName()
    {
        return 'co_eshopbundle_disocunttype';
    }

}
