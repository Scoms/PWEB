<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Ensiie\Bundle\DataBundle\DataFixtures\ORM;
 
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ensiie\Bundle\DataBundle\Entity\Etudiant;
use Ensiie\Bundle\DataBundle\Entity\Examen;
use Ensiie\Bundle\DataBundle\Entity\Depot;

class Depots extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        
        $depot = new Depot();
        $depot->setEtudiant($manager->getRepository("EnsiieDataBundle:Etudiant")->findOneBy(array("nom"=>"Wieser")));
        $depot->setExamen($manager->getRepository("EnsiieDataBundle:Examen")->findOneBy(array("libelle"=>"TP noté")));
        $depot->setPath("CR-BDE_24_04_13.pdf");
        $depot->setNote(15);
        $manager->persist($depot);
        
        $depot = new Depot();
        $depot->setEtudiant($manager->getRepository("EnsiieDataBundle:Etudiant")->findOneBy(array("nom"=>"Risoli")));
        $depot->setExamen($manager->getRepository("EnsiieDataBundle:Examen")->findOneBy(array("libelle"=>"TP noté")));
        $depot->setPath("CR-BDE_24_04_13.pdf");
        $depot->setNote(10);
        $manager->persist($depot);
        
        $depot = new Depot();
        $depot->setEtudiant($manager->getRepository("EnsiieDataBundle:Etudiant")->findOneBy(array("nom"=>"Heckel")));
        $depot->setExamen($manager->getRepository("EnsiieDataBundle:Examen")->findOneBy(array("libelle"=>"TP noté")));
        $depot->setPath("CR-BDE_24_04_13.pdf");
        $depot->setNote(18);
        $manager->persist($depot);
        
         $manager->flush();
        
    }   
            
    public function getOrder()
      {
        return 10; // the order in which fixtures will be loaded
      }

}
?>
