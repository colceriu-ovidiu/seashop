<?php
namespace TSC\WebsiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description');
        $builder->add('price');
        $builder->add('pic_file');
        //$builder->add('pic_file', 'file', array('property_path' => false) );
        //$builder->add('dueDate', null, array('widget' => 'single_text'));
    }

    public function getName()
    {
        return 'product';
    }
    
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'TSC\WebsiteBundle\Entity\Product',
        );
    }
}