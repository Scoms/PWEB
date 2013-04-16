<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Users.php
 
namespace PWEB\Bundle\UserBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Iaato\UserBundle\Entity\User; 

class Users extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $user = new User;
    $user->setUsername('superadmin');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');
    $user->setRoles(array('ROLE_ADMIN'));
    $manager->persist($user);
    $manager->flush();
  }
  public function getOrder()
  {
    return 1; // the order in which fixtures will be loaded
  }
}

?>
