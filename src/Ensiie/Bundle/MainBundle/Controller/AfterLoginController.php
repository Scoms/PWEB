<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AfterLoginController extends Controller
{
    public function redirectAction()
    {
	$user = $this->get('security.context')->getToken()->getUser();
	
	if($user->getRoles() == array('ROLE_GESTION'))
	  return $this->redirect($this->generateURL('ensiie_admin',array(),501));
	if($user->getRoles() == array('ROLE_PROF'))
	  return $this->redirect($this->generateURL('ensiie_prof',array(),501));
	if($user->getRoles() == array('ROLE_ETU'))
	  return $this->redirect($this->generateURL('ensiie_etu',array(),501));
	
	  return $this->redirect($this->generateURL('ensiie_homepage',array(),501));
    }
}
