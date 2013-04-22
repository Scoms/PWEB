<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Users.php
 
namespace Ensiie\Bundle\DataBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ensiie\Bundle\DataBundle\Entity\Examen; 

class Examens extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $dd = new \DateTime();
    $df = new \DateTime();
    $df->add(new \DateInterval('P1D'));
    $exam = new Examen;
    $exam->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les consommateurs")));
    $exam->setLibelle('IPA controle final');
    $exam->setDescription('Vous jouez votre vie sur cette exam !');
    $exam->setDateDebut($dd);
    $exam->setDateFin($df);
    $exam->setCoefficient(2);
    $manager->persist($exam);
    $manager->flush();
  }
  public function getOrder()
  {
    return 2; // the order in which fixtures will be loaded
  }
}

?>
