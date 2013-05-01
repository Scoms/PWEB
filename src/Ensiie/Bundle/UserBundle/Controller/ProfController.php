<?php

// src/PWEB/Bundle/UserBundle/Controller/InscriptionController.php

namespace Ensiie\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Ensiie\Bundle\UserBundle\Entity\User;
use Ensiie\Bundle\UserBundle\Form\Type\UserType;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;

class ProfController extends Controller
{
  public function indexAction()
  { 
    $log = $this->get('logger');
    $request = $this->get('request');
    $em = $this->getDoctrine()->getManager();
    
    $user = new User;
    $form = $this->createForm(new UserType(),$user);
    
    $log->info('vérification de la méthode');
    if ($request->getMethod() == 'POST')
    {
      $form->bind($request);
      if ($form->isValid())
      {
	$log->info('Vaild form');
	$user->setPassword(sha1($user->getPassword()));
	$user->setSalt('');
	$user->setRoles(array('ROLE_PROF'));
	$log->info('Check username');
	if($em->getRepository("EnsiieUserBundle:User")->findBy(array('username'=>$user->getUsername()) )!=NULL)
	  return $this->render('EnsiieUserBundle:Prof:index.html.twig',array(
	    'form' => $form->createView(),
	    'error'=>'ERROR : L\'utilisateur "'.$user->getUsername().'" existe déjà.',
	    'success'=>''));;
	
	$em->persist($user);
	$em->flush();
      }
      $log->info('chack password');
      if($user->getPassword() == '')
	return $this->render('EnsiieUserBundle:Prof:index.html.twig',array(
	  'form' => $form->createView(),
	  'error'=>'Mot de passe invalide',
	  'success'=>''));
      $log->info('success');
      return $this->render('EnsiieUserBundle:Prof:index.html.twig',array(
		'form' => $form->createView(),
		'error'=>'',
		'success'=>'L\'utilisateur "'.$user->getUsername().'" a été ajouté avec succès.'));
    }
    return $this->render('EnsiieUserBundle:Prof:index.html.twig', array(
      "form"=>$form->createView(),
      "error"=>'',
      'success'=>'',
      ));
  }
}