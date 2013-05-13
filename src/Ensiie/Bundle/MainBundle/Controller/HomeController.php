<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction($tri)
    {
      $em = $this->getDoctrine()->getManager();
      $request = $this->get('request');
      $log = $this->get('logger');
      $user = $this->get('security.context')->getToken()->getUser();
      $log->info('HomeController indexAction');
    
      if($tri == "promo")
      $exams = $em->getRepository('EnsiieDataBundle:Examen')->triePromo();     
      elseif($tri == "exam")
      $exams = $em->getRepository('EnsiieDataBundle:Examen')->trieExamen();
                
      
      $log->info('Debut du calcul de la moyenne pour chaque examen');
      $moyennes_exams = $this->calcMoyenne($exams); 
      
      $log->info('Debut du calcul de la moyenne par promo');
      $moyennes_promos = $this->calcMoyennePromo($moyennes_exams);                
      
       $log->info('rendu');
        return $this->render('EnsiieMainBundle:Home:index.html.twig',
                array('moyennes_exams' => $moyennes_exams, 
                      'moyennes_promos' => $moyennes_promos)
                );
    }
    
    public function calcMoyennePromo($moyennes_exams)
    {
      $request = $this->get('request');
      $log = $this->get('logger');
      $moyennes_promos = array();     
         
      foreach($moyennes_exams as $moyenne1 => $exam1)
       {           
            $moyenne_promo = $moyenne1 * $exam1->getCoefficient();
            $count_promo = $exam1->getCoefficient();
            $promo_calculee = array();
            $promo1 = $exam1->getPromo()->getLibelle();           
            
            foreach($moyennes_exams as $moyenne2 => $exam2)
            {                
                $promo2 = $exam2->getPromo()->getLibelle();                
                
                if($promo1 == $promo2
                && ( $exam1->getLibelle() != $exam2->getLibelle() )
                && !in_array($promo2, $promo_calculee))
                {   
                    $log->info('Prise en compte du coeff');
                    for($i=1; $i <= $exam2->getCoefficient(); $i++)
                    {
                        $moyenne_promo += $moyenne2;
                        $count_promo++;
                    }                    
                }
            }
            $moyenne_promo /= $count_promo;
            array_push($promo_calculee, $promo1);
            $moyennes_promos[$promo1] = $moyenne_promo;
       }
       return $moyennes_promos;
    }
    
    public function calcMoyenne($exams)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $log = $this->get('logger');
        $moyennes_exams = array();
        
        foreach($exams as $exam)
          {
              $id = $exam->getId();
              $depots = $em->getRepository('EnsiieDataBundle:Depot')->findBy(array("examen"=>$id));

              $nb_depots = 0;
              $moyenne = 0;          

              $log->info('Calcul de la moyenne d\' un examen a partir des tous les depots attenants');
              foreach($depots as $depot)
              {
                  if($depot->getNote()!=null)
                  {
                    $moyenne += $depot->getNote();
                    $nb_depots++;
                  }
              }
              if($nb_depots != 0)
              {
                  $moyenne = $moyenne / $nb_depots;
                  $log->info('Ajout de la moyenne calculee dans la liste des moyennes');
                  $moyennes_exams[strval($moyenne)] = $exam;
              }                    
          }
          return $moyennes_exams;
    }

}
