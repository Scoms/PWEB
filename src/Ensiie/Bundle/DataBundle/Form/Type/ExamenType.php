<?php
// src/Ensiie/Bundle/DataBundle/Form/Type/TaskType.php
namespace Ensiie\Bundle\DataBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExamenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$builder
	->add('libelle','text')
	->add('description','textarea')
	->add('coefficient','number')
	->add('date_debut','datetime')
	->add('date_fin','datetime');
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ensiie\Bundle\DataBundle\Entity\Examen',
        ));
    }
    public function getName()
    {
        return 'examen';
    }
}
?>