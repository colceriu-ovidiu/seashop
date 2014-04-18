<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('email', 'email');
        $builder->add('body', 'textarea');
    }
	
	//public function getDefaultOptions(OptionsResolverInterface $resolver)
	//public function getDefaultOptions()
	public function getDefaultOptions(array $options)
    {
        $collectionConstraint = new Collection(array(
            'name' => array(
				new MinLength(array('limit'=>7, 'message' => 'numele trebuie sa fie din minim {{ limit }} caractere')),
			),
            'email' => array(
				new Email(array('message' => 'Invalid email address')),
			),
			'body' => array(
				new MinLength(array('limit'=>10, 'message' => 'continutul trebuie sa fie din minim {{ limit }} caractere') )
			)
        ));
        
		//$options = parent::getDefaultOptions($options);
		
		return array(
            //'data_class' => 'My\TestBundle\Core\Test',
            'validation_constraint' => $collectionConstraint
        );
		
		/*$resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));*/
		/*return array(
              'currency' => null,
			);*/
    }	

    public function getName()
    {
        return 'contact';
    }
}
