<?php

// src/PWEB/Bundle/UserBundle/Controller/InscriptionController.php

namespace Ensiie\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Ensiie\Bundle\UserBundle\Entity\User;

class InscriptionController extends Controller
{
  public function indexAction()
  { 
    //variables de base
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $logger = $this->get('logger');
    $logger->info('START INSCRIPTION');
    
    $user = new User;
    
    //Création du formulaire de manière abstraite
    $formBuilder = $this->createFormBuilder($user);
    $formBuilder
      ->add('username','text');
      
    $form = $formBuilder->getForm();
    
    
    $logger->info('get method');
    if($request->getMethod() == 'POST')
    {
      $form->bind($request);
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
	  $logger->('utilisateur ajouté');
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
      else
      {
	return $this->render('EnsiieUserBundle:Inscription:index.html.twig',array(
	    'form'=>$form->createView(),
	    'error'=>"Invalid Form",
	    'success'=>'',
	  ));
      }
    }
    $logger->info('return index');
    
    return $this->render('EnsiieUserBundle:Inscription:index.html.twig',array(
      'form'=>$form->createView(),
      'error'=>'',
      'success'=>'',
    ));
  }
}

?>
