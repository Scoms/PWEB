<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Users.php
 
namespace Ensiie\Bundle\DataBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ensiie\Bundle\DataBundle\Entity\Promo; 

class Promos extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $promo = new Promo;
    $promo->setLibelle("Pas de promo");
    $manager->persist($promo);
    $promo = new Promo;
    $promo->setLibelle("Les consommateurs");
    $manager->persist($promo);
    $promo = new Promo;
    $promo->setLibelle("Les défricheurs");
    $manager->persist($promo);
    $promo = new Promo;
    $promo->setLibelle("Les pionniers");
    $manager->persist($promo);
    $manager->flush();
  }
  public function getOrder()
  {
    return 1; // the order in which fixtures will be loaded
  }
}

?>
