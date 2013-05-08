<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Users.php
 
namespace Ensiie\Bundle\DataBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ensiie\Bundle\DataBundle\Entity\Depot;

class Depots extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $repo_etu = $manager->getRepository('EnsiieDataBundle:Etudiant');
    $repo_examen = $manager->getRepository('EnsiieDataBundle:Examen');
    $repo_promo = $manager->getRepository('EnsiieDataBundle:Promo');
    
    $promo_consommateurs = $repo_promo->findOneBy(array("libelle"=>"Les consommateurs"));
    
    $array_etus_conso = $repo_etu->findBy(array("promo"=>$promo_consommateurs));
    
    // Remplissage de l'examen de MOM 1A 1
    // /!\ un étudiant n'as pas rendu l'éxamen
    $examen = $repo_examen->findOneBy(array("libelle"=>"MOM 1A 1"));
    foreach($array_etus_conso as $etu)
    {
      //Tristan ne dépose pas 
      if($etu != $repo_etu->findOneBy(array("nom"=>"Guillevin")))
      {
	$depot = new Depot;
	$depot->setEtudiant($etu);
	$depot->setExamen($examen);
	$depot->setNote(rand(0,20));
	$manager->persist($depot);
      }
      // else ne rien faire
    }
    
    $manager->flush();
  }
  public function getOrder()
  {
    return 4; // the order in which fixtures will be loaded
  }
}

?>
