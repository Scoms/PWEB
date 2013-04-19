<?php

namespace Ensiie\Bundle\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FileExamenType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('file')
        ;
    }
    public function getName()
    {
        return 'ensiie_databundle_filetype';
    }
}