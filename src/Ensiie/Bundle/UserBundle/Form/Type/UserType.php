<?php

namespace Ensiie\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username','text')
            ->add('password', 'repeated', array(
		'type' => 'password',
		'invalid_message' => 'Les mots de passes doivent correspondrent.',
		'options' => array('attr' => array('class' => 'password-field')),
		'required' => true,
		'first_options'  => array('label' => 'Mot de passe'),
		'second_options' => array('label' => 'Répéter mot de passe'),
			))
	    ;
    }
    public function getName()
    {
        return 'usertype';
    }
}