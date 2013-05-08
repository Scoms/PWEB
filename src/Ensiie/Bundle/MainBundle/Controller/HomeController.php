<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $request = $this->get('request');
      $log = $this->get('logger');
      $log->info('HomeController indexAction');
      
      $exams = $em->getRepository('EnsiieDataBundle:Examen')->findAll();
      
      $log->info('Calcul de la moyenne pour chaque examen');
      $moyennes = array();
     
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
          $moyenne = $moyenne / $nb_depots;
          
          $log->info('Ajout de la moyenne calculee dans la liste des moyennes');
          array_push($moyennes,$moyenne);
      }
      
      
        
        return $this->render('EnsiieMainBundle:Home:index.html.twig',
                array('moyennes' => $moyennes, 'exams' => $exams )
                );
    }
}
