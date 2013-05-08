<?php
// src/Ensiie/Bundle/DataBundle/Form/Type/TaskType.php
namespace Ensiie\Bundle\DataBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	$builder
	->add('nom','text')
	->add('prenom','text')
	->add('adresse','text')
	->add('codePostal','text')
	->add('ville','text')
	->add('email','text')
	->add('telephone','text')
	;
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ensiie\Bundle\DataBundle\Entity\Etudiant',
        ));
    }
    public function getName()
    {
        return 'etudiant';
    }
}
?>