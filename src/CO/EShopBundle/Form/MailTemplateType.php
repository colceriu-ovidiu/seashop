<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\Collection;

class MailTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', 'textarea');
    }
	
	//public function getDefaultOptions(OptionsResolverInterface $resolver)
	//public function getDefaultOptions()
	/*public function getDefaultOptions(array $options)
    {
        $collectionConstraint = new Collection(array(
			'content' => array(
				new MinLength(array('limit'=>10, 'message' => 'continutul trebuie sa fie din minim {{ limit }} caractere') )
			)
        ));
		
		return array(
            //'data_class' => 'My\TestBundle\Core\Test',
            'validation_constraint' => $collectionConstraint
        );
		

    }	*/

    public function getName()
    {
        return 'mailTemplate';
    }
}
