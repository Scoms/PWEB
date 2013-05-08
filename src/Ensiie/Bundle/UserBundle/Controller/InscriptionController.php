<?php

// src/PWEB/Bundle/UserBundle/Controller/InscriptionController.php

namespace Ensiie\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Ensiie\Bundle\UserBundle\Entity\User;
use Ensiie\Bundle\DataBundle\Entity\Etudiant;
use Ensiie\Bundle\DataBundle\Form\Type\EtudiantType;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;

class InscriptionController extends Controller
{
  public function indexAction()
  { 
    //variables de base
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $logger = $this->get('logger');
    $logger->info('START INSCRIPTION');
    
    $etudiant = new Etudiant;
    
    $promos = new EntityChoiceList($em,'Ensiie\Bundle\DataBundle\Entity\Promo');
    //Création du formulaire de manière abstraite
    $form = $this->createForm(new EtudiantType(), $etudiant);
    $form->add('promo','choice',array(
      'choice_list' => $promos,
    'required' => false,
    'empty_value' => 'Choisir une promo',
    'empty_data'  => null))
    ;
    
    $logger->info('get method');
    if($request->getMethod() == 'POST')
    {
      $form->bind($request);
      if($form->isValid())
      {
	$logger->info('création d\'un utilisateur.');
	$user = new User;
	
	$logger->info('Génération UserName');
	
	$user->setUserName(
	  substr($etudiant->getPrenom(),0,1)
	  .".".
	  substr($etudiant->getNom(),0,8)
	);
	$i = 0;
	$init_size = strlen($user->getUsername());
	while($em->getRepository("EnsiieUserBundle:User")->findBy(array("username"=>$user->getUsername()))!=NULL)
	{
	  if($i==0)
	    $user->setUserName($user->getUsername()."1");
	  else
	    $user->setUserName(substr($user->getUsername(),0,$init_size).$i);
	  $i++;
	}
	
	$logger->info('Génération Password');
	
	$mdp = $this->Genere_Password(10);
	$user->setPassword(sha1($mdp));
	$user->setRoles(array('ROLE_ETU'));
	$user->setSalt('');
	$etudiant->setUser($user);
	$em->persist($etudiant);
	$em->persist($user);
	$em->flush();
	$logger->info('utilisateur ajouté');
	
	return $this->render('EnsiieUserBundle:Inscription:index.html.twig',array(
	    'form'=>$form->createView(),
	    'error'=>"",
	    'success'=> "Vous avez bien été ajouté ! \nLogin : ".$user->getUsername()."\n"."Mot de passe :".$mdp,
	  ));
      }
      else
      {
	return $this->render('EnsiieUserBundle:Inscription:index.html.twig',array(
	    'form'=>$form->createView(),
	    'error'=>"Invalid Form",
	    'success'=>"",
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
  public function Genere_Password($size)
 {
    // Initialisation des caracteres utilisables
     $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
     $password = '';

     for($i=0;$i<$size;$i++)
     {
            $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
     }
                                
     return $password;
 }
}

?>
