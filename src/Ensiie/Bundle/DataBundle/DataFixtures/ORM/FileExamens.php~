<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Users.php
 
namespace Ensiie\Bundle\DataBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ensiie\Bundle\DataBundle\Entity\FileExamen; 

class FileExamens extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    /*
     * Exams d'IPA 
     *//*
    $file= new FileExamen;
    $file->setName("1A final IPA");
    $file->setPath("exam_IPA_1A_2.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"p.mathis")));
    $manager->persist($file);
    
    $file= new FileExamen;
    $file->setName("1A Intermédiaire IPA");
    $file->setPath("exam_IPA_1A_1.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"p.mathis")));
    $manager->persist($file);
    */
    /*
     * Exams Economie
     *//*
    $file= new FileExamen;
    $file->setName("EMI");
    $file->setPath("micro.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"m.weil")));
    $manager->persist($file);
        
    $file= new FileExamen;
    $file->setName("EMA");
    $file->setPath("macro.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"m.weil")));
    $manager->persist($file);
    
    $file= new FileExamen;
    $file->setName("ECO 2A");
    $file->setPath("economie.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"m.weil")));
    $manager->persist($file);
    */
    /*
     * Exams Pweb
     *//*
    $file= new FileExamen;
    $file->setName("Projets Pweb");
    $file->setPath("sujet_groupes.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"b.gassmann")));
    $manager->persist($file);
    
    $file= new FileExamen;
    $file->setName("Projets Pweb ");
    $file->setPath("sujet_groupes_1A.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"b.gassmann")));
    $manager->persist($file);
    */
    /*
     * Exams maths
     *//*
    $file= new FileExamen;
    $file->setName("Intermédiaire 1A");
    $file->setPath("mom_1_1A.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"a.faye")));
    $manager->persist($file);
    
    $file= new FileExamen;
    $file->setName("Intermédiaire 1A");
    $file->setPath("mom_2_1A.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"a.faye")));
    $manager->persist($file);
    */
    /*
      * Exams réseau
      */  /*
    $file= new FileExamen;
    $file->setName("Réseau final 2A");
    $file->setPath("ISE3.pdf");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"s.genaud")));
    $manager->persist($file);
      
    $manager->flush();*/
  }
  public function getOrder()
  {
    return 2; // the order in which fixtures will be loaded
  }
}

?>
