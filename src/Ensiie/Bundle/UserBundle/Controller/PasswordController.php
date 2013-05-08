<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ensiie\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Ensiie\Bundle\UserBundle\Entity\User;
use Ensiie\Bundle\UserBundle\Form\Type\UserType;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;

class PasswordController extends Controller
{
    public function changeAction()
        {
            $log = $this->get('logger');
            $request = $this->get('request');
            $em = $this->getDoctrine()->getManager();
            
            $log->info('vérification de la méthode');
           
            $user = $this->get('security.context')->getToken()->getUser();
            $form = $this->createFormBuilder($user)
                         ->add('old_password','password',array(
                              "mapped" => false,
                              "label" => "Entrez votre ancien mot de passe:",
                          ))  
                         ->add('new_password','password',array(
                             "mapped" => false,
                             "label" => "Entrez votre nouveau mot de passe:",
                         ))
                         ->add('same_password','password',array(
                             "mapped" => false,
                             "label" => "Rentrez de nouveau votre nouveau mot de passe:",
                         ))
                         ->getForm();
      
            
            if ($request->getMethod() == 'POST')
            {
              $form->bind($request);
              
              $log->info('check old password');
              if( sha1($form["old_password"]->getData()) != $user->getPassword())  
                    return $this->render('EnsiieUserBundle:Password:index.html.twig',array(
                      'form' => $form->createView(),
                      'error'=>'Ancien mot de passe incorrect',
                      'success'=>''));
              
              $log->info('check same new password');
              if( $form["new_password"]->getData() != $form["same_password"]->getData())  
                    return $this->render('EnsiieUserBundle:Password:index.html.twig',array(
                      'form' => $form->createView(),
                      'error'=>'Vous n\'avez pas entré deux fois le même mot de passe',
                      'success'=>''));
                  
                $log->info('Change password');
                $user->setPassword(sha1($form["new_password"]->getData()));
                $user->setSalt('');
                
                $em->flush();              
             
                $log->info('success');
                return $this->render('EnsiieUserBundle:Password:index.html.twig',array(
                            'form' => $form->createView(),
                            'error'=>'',
                            'success'=>'Votre mot de passe a été changé avec succès.'));
              
            }
            return $this->render('EnsiieUserBundle:Password:index.html.twig', array(
              "form"=>$form->createView(),
              "error"=>'',
              'success'=>'',
              ));

        }
}
?>
