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
      
      $log->info('Debut du calcul des moyennes par promo');
      $moyennes_promos = array();
      $moyennes_promos_res = array();
      
      $log->info('Contruction du tableau moyenne -> promo ne contenant pas les examens ');
      foreach($moyennes_exams as $moyenne => $exam)
       {
            $promo = $exam->getPromo()->getLibelle();
            $moyennes_promos[$moyenne] = $promo;
       }
      $log->info('Tableau contenant promo -> nombre d\'examens attenants'); 
      $count_occurrences = array_count_values($moyennes_promos);
      
      
      
      $log->info('Calcul de la moyenne pour chaque promo');
      foreach($moyennes_promos as $moyenne1 => $promo1)
       {      
        if($count_occurrences[$promo1] == 1)
        {
            $log->info('Cas simple d\'un seul examen');
            $moyenne_temp = $moyenne1;
        }        
        else
        {
            $log->info('Cas complexe de plusieurs examens');
            $moyenne_temp = 0;
            foreach($moyennes_promos as $moyenne2 => $promo2)
            {
                if($promo1 == $promo2)
                {
                    $moyenne_temp += $moyenne2;
                }                    
            }
            $moyenne_temp /= $count_occurrences[$promo1];
        }
        $log->info('Dans tous les cas ajout de moyenne -> promo');
        $moyennes_promos_res[$promo1] = $moyenne_temp;
       }                      
       $log->info('rendu');
        return $this->render('EnsiieMainBundle:Home:index.html.twig',
                array('moyennes_exams' => $moyennes_exams, 
                      'moyennes_promos' => $moyennes_promos_res)
                );
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
