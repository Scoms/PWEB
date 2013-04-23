<?php
// src/Iaato/UserBundle/DataFixtures/ORM/Users.php
 
namespace Ensiie\Bundle\DataBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ensiie\Bundle\DataBundle\Entity\Etudiant;
use Ensiie\Bundle\UserBundle\Entity\User;

class Etudiants extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $etu = new Etudiant;
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les consommateurs")));
    $etu->setNom('Wieser');
    $etu->setPrenom('Laurent');
    $etu->setAdresse('rue de Montréal tantan');
    $etu->setCodePostal('67670');
    $etu->setVille('Mommenheim');
    $etu->setEmail('laurentwieser@hotmail.com');
    $etu->setTelephone('0650511711');
    
    $user = new User;
    $user->setUserName('l.wieser');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');
    $user->setRoles(array('ROLE_ETU'));
    
    $etu->setUser($user);
    
    $manager->persist($user);
    $manager->persist($etu);
    $etu = new Etudiant;
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les défricheurs")));
    $etu->setNom('Risoli');
    $etu->setPrenom('Phillipe');
    $etu->setAdresse('7 rue du fromage');
    $etu->setCodePostal('75006');
    $etu->setVille('Paris');
    $etu->setEmail('krautergersheim@plop.tk');
    $etu->setTelephone('0101010101');
    //$etu->setUserName('p.risoli');
    //$etu->setPassword(sha1('pass'));
    //$etu->setSalt('');
    //$etu->setRoles(array('ROLE_ETU'));
    $manager->persist($etu);
    $manager->flush();
  }
  public function getOrder()
  {
    return 2; // the order in which fixtures will be loaded
  }
}

?>
