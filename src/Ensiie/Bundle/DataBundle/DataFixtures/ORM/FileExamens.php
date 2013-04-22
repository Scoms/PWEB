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
    $file= new FileExamen;
    $file->setName("test");
    $file->setPath("test");
    $file->setUser($manager->getRepository("EnsiieUserBundle:User")->findOneBy(array("username"=>"p.mathis")));
    $manager->persist($file);
    $manager->flush();
  }
  public function getOrder()
  {
    return 1; // the order in which fixtures will be loaded
  }
}

?>
