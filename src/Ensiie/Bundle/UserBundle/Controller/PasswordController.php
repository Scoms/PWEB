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
                         ->add('password','password')
                         ->getForm();
      
            
            if ($request->getMethod() == 'POST')
            {
              $form->bind($request);
              if ($form->isValid())
              {
                $log->info('Valid form');
                $user->setPassword(sha1($user->getPassword()));
                $user->setSalt('');
                
                $em->flush();
              }
            /*  $log->info('chack password');
              if($user->getPassword() == '')
                return $this->render('EnsiieUserBundle:Prof:index.html.twig',array(
                  'form' => $form->createView(),
                  'error'=>'Mot de passe invalide',
                  'success'=>''));*/
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
