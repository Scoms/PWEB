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
  {/*
    $etu = new Etudiant;
    
    //Promo des consommateurs
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
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les consommateurs")));
    $etu->setNom('Risoli');
    $etu->setPrenom('Phillipe');
    $etu->setAdresse('7 rue du fromage');
    $etu->setCodePostal('75006');
    $etu->setVille('Paris');
    $etu->setEmail('krautergersheim@plop.tk');
    $etu->setTelephone('0101010101');
    
    $user = new User;
    $user->setUserName('p.risoli');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');
    $user->setRoles(array('ROLE_ETU'));
    
    $etu->setUser($user);
    $manager->persist($user);
    $manager->persist($etu);
    
    $etu = new Etudiant;
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les consommateurs")));
    $etu->setNom('Guillevin');
    $etu->setPrenom('Tristan');
    $etu->setAdresse('rue de munster');
    $etu->setCodePostal('67000');
    $etu->setVille('Strasbourg');
    $etu->setEmail('tristan.guillevin@hotmail.com');
    $etu->setTelephone('0666666666');
    
    $user = new User;
    $user->setUserName('t.guillevin');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');	
    $user->setRoles(array('ROLE_ETU'));
    
    $etu->setUser($user);  
    $manager->persist($user);
    $manager->persist($etu);
    
    $etu = new Etudiant;
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les consommateurs")));
    $etu->setNom('Deutschmann');
    $etu->setPrenom('Noël');
    $etu->setAdresse('rue des cygnes');
    $etu->setCodePostal('67500');
    $etu->setVille('Eckolsheim');
    $etu->setEmail('nonolepetitrobot@hotmail.com');
    $etu->setTelephone('0666666666');
    
    $user = new User;
    $user->setUserName('n.deutschm');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');	
    $user->setRoles(array('ROLE_ETU'));
    
    $etu->setUser($user);  
    $manager->persist($user);
    $manager->persist($etu);
    
    $etu = new Etudiant;
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les consommateurs")));
    $etu->setNom('Heckel');
    $etu->setPrenom('Maxime');
    $etu->setAdresse('?');
    $etu->setCodePostal('67670');
    $etu->setVille('Strasbourg');
    $etu->setEmail('maxime.etquel@hotmail.com');
    $etu->setTelephone('0666666666');
    
    $user = new User;
    $user->setUserName('m.heckel');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');	
    $user->setRoles(array('ROLE_ETU'));
    
    $etu->setUser($user);  
    $manager->persist($user);
    $manager->persist($etu);
    
    //Promo des défricheurs 
    
    $etu = new Etudiant;
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les defricheurs")));
    $etu->setNom('Caravelli');
    $etu->setPrenom('Xavier');
    $etu->setAdresse('rue des juifs');
    $etu->setCodePostal('67670');
    $etu->setVille('Strasbourg');
    $etu->setEmail('xavou@hotmail.com');
    $etu->setTelephone('0666666666');
    
    $user = new User;
    $user->setUserName('x.cavarelli');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');	
    $user->setRoles(array('ROLE_ETU'));
    
    $etu->setUser($user);  
    $manager->persist($user);
    $manager->persist($etu);
    
    
    $etu = new Etudiant;
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les defricheurs")));
    $etu->setNom('Thenoz');
    $etu->setPrenom('Quetin');
    $etu->setAdresse('rue de dijon');
    $etu->setCodePostal('67670');
    $etu->setVille('Dijon');
    $etu->setEmail('surmamotobylettejesuisleroi@hotmail.com');
    $etu->setTelephone('0666666666');
    
    $user = new User;
    $user->setUserName('q.thenoz');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');	
    $user->setRoles(array('ROLE_ETU'));
    
    $etu->setUser($user);  
    $manager->persist($user);
    $manager->persist($etu);
    
    
    $etu = new Etudiant;
    $etu->setPromo($manager->getRepository("EnsiieDataBundle:Promo")->findOneBy(array("libelle"=>"Les defricheurs")));
    $etu->setNom('Gouy');
    $etu->setPrenom('Paul');
    $etu->setAdresse('rue des pauls');
    $etu->setCodePostal('67670');
    $etu->setVille('Strasbourg');
    $etu->setEmail('paulœ@hotmail.com');
    $etu->setTelephone('0666666666');
    
    $user = new User;
    $user->setUserName('p.gouy');
    $user->setPassword(sha1('pass'));
    $user->setSalt('');	
    $user->setRoles(array('ROLE_ETU'));
    
    $etu->setUser($user);  
    $manager->persist($user);
    $manager->persist($etu);
    
    $manager->flush();
  */}
  public function getOrder()
  {
    return 2; // the order in which fixtures will be loaded
  }
}

?>
