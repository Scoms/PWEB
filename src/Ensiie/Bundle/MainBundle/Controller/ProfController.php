<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ensiie\Bundle\DataBundle\Entity\Examen;

class ProfController extends Controller
{
    public function indexAction()
    {
	$examen = new Examen;
	
	$fb = $this->createFormBuilder($examen);
	
	$fb
	  ->add('file');
	  
	$form = $fb->getForm();
	if($form->isValid())
      {
	$logger->info("verification existance de l'utilisateur");
	if($em->getRepository("EnsiieUserBundle:User")->findBy(array("username"=>$user->getUsername()))==NULL)
	{
	  $logger->info("utilisateur unique, génération du mot de passe");
	  $mdp = $user->getUsername()."secure";
	  $user->setPassword(sha1($mdp));
	  $user->setRoles(array('ROLE_ETU'));
	  $user->setSalt('');
	  $em->persist($user);
	  $em->flush();
	  $logger->info('utilisateur ajouté');
	  
	  return $this->render('EnsiieUserBundle:Inscription:index.html.twig',array(
	    'form'=>$form->createView(),
	    'error'=>'',
	    'success'=>'L\'utilisateur "'.$user->getUsername().'" à bien été ajouté avec le mot de passe : '.$mdp,
	  ));
	}
	return $this->render('EnsiieUserBundle:Inscription:index.html.twig',array(
	    'form'=>$form->createView(),
	    'error'=>"Veuillez choisir un nom d'utilisateur UNIQUE SVP",
	    'success'=>'',
	  ));
      }
	
        return $this->render('EnsiieMainBundle:Prof:index.html.twig',array(
	  'form' => $form->createView(),
        ));
    }
}
