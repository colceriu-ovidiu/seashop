<?php

namespace CO\EShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

use CO\EShopBundle\Entity\User;

class UserType extends AbstractType
{
	private $perstypes = array(1=>'Persoana Fizica', 2=>'Persoana Juridica');
	
	public $useCredetials = true;
	
	public function init() {		
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$this->init();
		
		$builder
			->add('email', 'text' , array(
						'label' => 'Email',
						'constraints' => array(
							   new NotBlank(),
							   new Email(array("message"=>"adresa de mail nu este valida")),
						   )
					));
		if ($this->useCredetials) {
			$builder
				//->add('username')
				->add('password', 'password' , array(
							'label' => 'Parola'
						));
		}

		$builder
            ->add('perstype', 'choice',array(
						'label' => 'Tip de Persoana',
						'choices' => $this->perstypes,
						'multiple' => false,
						'expanded' => true
					))
            ->add('fullname', 'text' , array(
						'label' => 'Nume Intreg',
						'required' => false,
						'attr' => array('row_class'=> 'pf')
					))
            ->add('phone', 'text', array(
						'label' => 'Telefon',
						'required' => false,
						'attr'   =>  array(
						                'row_class'   => 'pf'
						            )
					))
            ->add('postalCode', 'text', array(
						'label' => 'Cod postal'
					))
            ->add('compName', 'text', array(
						'label' => 'Companie',
						'required' => false,
						'attr'   =>  array(
						                'row_class'   => 'pc'
						            )
					))
	        ->add('compFiscalCode', 'text', array(
						'label' => 'Cod Fiscal',
						'required' => false,
						'attr'   =>  array(
						                'row_class'   => 'pc'
						            )
					))
	        ->add('compNrReg', 'text', array(
						'label' => 'Nr.Reg',
						'required' => false,
						'attr'   =>  array(
						                'row_class'   => 'pc'
						            )
					))
	        ->add('compPersName', 'text', array(
						'label' => 'Persoana de contact',
						'required' => false,
						'attr'   =>  array(
						                'row_class'   => 'pc'
						            )
					))
	        ->add('compPersPhone', 'text', array(
						'label' => 'Telefon persoana de contact',
						'required' => false,
						'attr'   =>  array(
						                'row_class'   => 'pc'
						            )
					))
            ->add('address', 'textarea', array (
						'required' => false,	
						'label' => 'Adresa de facturare'
					))
            
            ->add('addrsship', 'textarea', array (
						'required' => false,
						'label' => 'Adresa de livrare'
					))
            ->add('obs', 'textarea', array (
						'required' => false,
						'label' => 'Observatii'
					))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CO\EShopBundle\Entity\User',
			'validation_groups' => function(FormInterface $form) {
		            $data = $form->getData();
		            if (User::TYPE_PERSON == $data->getPerstype()) {
		                return array('person');
		            } else {
		                return array('company');
		            }
		        },
        ));
    }

    public function getName()
    {
        return 'co_eshopbundle_usertype';
    }
}
