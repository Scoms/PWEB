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
  public function removeAction($b)
  {
  
    $em = $this->getDoctrine()->getManager();
    $liste_user = $em->getRepository("EnsiieUserBundle:User")->findAll();
    $user = new User();
    asort($liste_user,SORT_STRING);
    $formBuilder = $this->createFormBuilder($user);
    $formBuilder
	->add('username', 'entity', array(
	'class'=>'EnsiieUserBundle:User',
        'choices' => $liste_user,
        'required' => false,'label'=>'Login','multiple'=>false
	));
    $form = $formBuilder->getForm();
    $request = $this->get('request');	
    if ($request->getMethod() == 'POST')
    {
      $form->bind($request);
      if ($form->isValid())
      {
	$nom = $user->getUsername();
	$user = $em->getRepository('EnsiieUserBundle:User')->findOneBy(array('username' => "".$nom));
	if($user==NULL)
	{
	  return $this->render('EnsiieUserBundle:Prof:remove.html.twig',array(
	    'success'=>'',
	    'error'=>'ERROR : l\'utilisateur "'.$nom.'" n\'éxiste pas .',
	    'form' => $form->createView(),
	    
	    ));
	}
	$em->remove($user);
	$em->flush();
	  return $this->redirect($this->generateUrl('ensiie_admin_retraitprof',array("b"=>$nom), 301));
      }	
      return $this->render('EnsiieUserBundle:Prof:remove.html.twig',array(
	'success'=>'',
	'error'=>'',
	'form' => $form->createView(),
	));
    }
    else
    {
      $success='';
      if($b!="x")
	$success="L'utilisateur ".$b." a bien été supprimé.";
	
      return $this->render('EnsiieUserBundle:Prof:remove.html.twig',array(
	'success'=>$success,
	'error'=>'',
	'form' => $form->createView(),
	));
    }
  }
}