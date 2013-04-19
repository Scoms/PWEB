<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ensiie\Bundle\DataBundle\Entity\Examen;

class ProfController extends Controller
{
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();
      $request = $this->get('request');
      $logger = $this->get('logger');
      $examen = new Examen;
	
      $fb = $this->createFormBuilder($examen);
	
	$fb
	  ->add('libelle','text')
	  ->add('description','textarea')
	  ->add('date','datetime')	
	  ->add('coefficient','number')
	  ->add('file');
	  
	$form = $fb->getForm();
	
	if($request->getMethod() == 'POST')
	{
	  $form->bind($request);
	  if($form->isValid())
	  {
	    $em->persist($examen);
	    $em->flush();
	    return $this->render('EnsiieMainBundle:Prof:index.html.twig',array(
	    'form' => $form->createView(),
	  ));
	  }
	}
	
        return $this->render('EnsiieMainBundle:Prof:index.html.twig',array(
	  'form' => $form->createView(),
        ));
    }
}
