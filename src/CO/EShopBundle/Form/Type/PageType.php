<?php
namespace TSC\WebsiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PageType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
            ->add('content', 'textarea', array('attr' => array('class'=>'mceEditor') ))
        ;
	}

	public function getName()
	{
		return 'product';
	}

	public function getDefaultOptions(array $options)
	{
		return array(
            'data_class' => 'TSC\WebsiteBundle\Entity\Page',
		);
	}
}