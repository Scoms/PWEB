<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class EtuController extends Controller
{
    public function indexAction()
    {
	$em = $this->getDoctrine()->getManager();
	$user = $this->get('Security.context')->getToken()->getUser();
	$etudiant = $em->getRepository("EnsiieDataBundle:Etudiant")->findOneBy(array("user" => $user->getId())); 
        
        return $this->render('EnsiieMainBundle:Etu:index.html.twig',array(
	  "etudiant" => $etudiant));
    }
}
