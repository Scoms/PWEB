<?php

namespace Ensiie\Bundle\DataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ensiie\Bundle\DataBundle\Entity\Depot;
use Ensiie\Bundle\DataBundle\Form\Type\DepotType;

class ExamenEtudiantController extends Controller
{
    public function showAction()
    {
	//variables de base
	$em = $this->getDoctrine()->getManager();	
	$logger = $this->get('logger');
	$user = $this->get('security.context')->getToken()->getUser();
	$etudiant = $em->getRepository("EnsiieDataBundle:Etudiant")->findOneBy(array("user" => $user->getId()));
	//Fin variable de base
	
	$mes_examens_promo = array(); //$em->getRepository('EnsiieDataBundle:Examen')->findBy(array("promo" => $etudiant->getPromo()->getId()),array("date_debut"=>"desc"));
	$mes_rattrapages = array();
	$exams = $em->getRepository('EnsiieDataBundle:Examen')->findAll();
	foreach($exams as $rattrapage)
	{
	  foreach($rattrapage->getEtudiants() as $etu)
	  {
	    if($etu == $etudiant)
	      array_push($mes_rattrapages,$rattrapage);
	  }
	}
        return $this->render('EnsiieDataBundle:ExamenEtudiant:show.html.twig',array(
	  "mes_examens_promo" => $mes_examens_promo,
	  "mes_rattrapages" => $mes_rattrapages,
	  "var" => "",
	  "date" => new \Datetime(),
        ));
    }
    public function deposerAction($id)
    {
      $em = $this->getDoctrine()->getManager();	
      $logger = $this->get('logger');
      $user = $this->get('security.context')->getToken()->getUser();
      $etudiant = $em->getRepository('EnsiieDataBundle:Etudiant')->findOneBy(array("user"=>$user));
      $request = $this->get('request');
      $exam = $em->getRepository('EnsiieDataBundle:Examen')->find($id);
      $depot = new Depot;
      
      $form = $this->createForm(new DepotType(), $depot);
      
      if($request->getMethod() == 'POST')
	{
	  $form->bind($request);
	  $logger->info('Depot upload: form binded.');
	  if($form->isValid())
	  {
	    $depot->setEtudiant($etudiant);
	    $depot->setExamen($exam);
	    $logger->info('Changement ou nouveauté.');
	    $test = $em->getRepository("EnsiieDataBundle:Depot")->findOneBy(array("etudiant" => $etudiant,"examen"=>$exam));
	    if($test != "")
	    {
	    
		
	    $logger->info('++ suppression physique du fichier.');
		$em->remove($test);
		$depot->upload();
		$em->persist($depot);
		$em->flush(); 
		 return $this->render('EnsiieDataBundle:ExamenEtudiant:deposer.html.twig',array(
		  "form" => $form->createView(),
		  "success" => "Fichier modifier avec succès ! ",
		  "error" => "",
		  "exam"=>$exam,
		  ));
	    }
	    $depot->upload();
	    $em->persist($depot);
	    $em->flush();
	    return $this->render('EnsiieDataBundle:ExamenEtudiant:deposer.html.twig',array(
	    "exam"=>$exam,
	    "form" => $form->createView(),
	    "success" => "Le fichier ".$depot->getPath()." a été ajouté avec succès !",
	    "error" => "", 
	    ));
	  }	
	  else
	  {
	    return $this->render('EnsiieDataBundle:ExamenEtudiant:deposer.html.twig',array(
	    "exam"=>$exam,
	    "form" => $form->createView(),
	    "success" => "",
	    "error" => "fomulaire invalide.",
	    ));
	  }
	}
      return $this->render('EnsiieDataBundle:ExamenEtudiant:deposer.html.twig',array(
      "exam"=>$exam,
      "form"=>$form->createView(),
      "success"=>"",
      "error"=>"",
        ));
    }
}