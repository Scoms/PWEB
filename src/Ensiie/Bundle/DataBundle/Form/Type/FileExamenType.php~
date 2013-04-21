<?php
// src/Ensiie/Bundle/DataBundle/Form/Type/FileExamenType.php
namespace Ensiie\Bundle\DataBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileExamenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('path','textarea');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ensiie\Bundle\DataBundle\Entity\FileExamen',
        ));
    }

    public function getName()
    {
        return 'FileExamen';
    }
}
?>