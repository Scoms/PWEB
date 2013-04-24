<?php

namespace Ensiie\Bundle\DataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
	
	$mes_examens_promo = $em->getRepository('EnsiieDataBundle:Examen')->findBy(array("promo" => $etudiant->getPromo()->getId()),array("date_debut"=>"desc"));
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
	  "var" => $rattrapage->getEtudiants()[0],
	  "date" => new \Datetime(),
        ));
    }
}