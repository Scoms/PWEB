<?php

namespace Ensiie\Bundle\DataBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FileExamenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	    ->add('name')
            ->add('file');
    }
    public function getName()
    {
        return 'ensiie_databundle_filetype';
    }
}