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
                
      
      $log->info('Calcul de la moyenne pour chaque examen');
      $moyennes_exams = $this->calcMoyenne($exams);           
     
      
        return $this->render('EnsiieMainBundle:Home:index.html.twig',
                array('moyennes_exams' => $moyennes_exams )
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
