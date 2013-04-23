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
    //variables globales
    $promo_repo = $manager->getRepository("EnsiieDataBundle:Promo");
    $exam_repo = $manager->getRepository("EnsiieDataBundle:FileExamen");
    $user_repo = $manager->getRepository("EnsiieUserBundle:User");
    $etu_repo = $manager->getRepository("EnsiieDataBundle:Etudiant");
    $consommateurs = $promo_repo->findOneBy(array("libelle"=>"Les consommateurs"));
    
    $dd = new \DateTime();
    $df = new \DateTime();
    $df->add(new \DateInterval('P1D'));
    $exam = new Examen;
    $exam->setPromo($consommateurs);
    /*
      On ajoute les gens au rattrapages
      -phillipe risoli
    */
    $exam->addEtudiant($etu_repo->findOneBy(array("user" => $user_repo->findOneBy(array("username"=>"p.risoli")))));
    
    $exam->setFile($exam_repo->findOneBy(array("path"=>"exam_IPA.pdf")));
    $exam->setLibelle('IPA controle final');
    $exam->setDescription('Vous jouez votre vie sur cette exam !');
    $exam->setDateDebut($dd);
    $exam->setDateFin($df);
    $exam->setCoefficient(2);
    $manager->persist($exam);
    
    $exam = new Examen;
    $exam->setPromo($consommateurs);
    /*
      On ajoute les gens au rattrapages
    */    
    
    $exam->setFile($manager->getRepository("EnsiieDataBundle:FileExamen")->findOneBy(array("path"=>"macro.pdf")));
    $exam->setLibelle('Colle Macro');
    $exam->setDescription('Lol je fais de la macro aussi !');
    $exam->setDateDebut($dd);
    $exam->setDateFin($dd);
    $exam->setCoefficient(2);
    $manager->persist($exam);
    
    $manager->flush();
  }
  public function getOrder()
  {
    return 3; // the order in which fixtures will be loaded
  }
}

?>
