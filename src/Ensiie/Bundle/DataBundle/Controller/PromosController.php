<?php

namespace Ensiie\Bundle\DataBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Ensiie\Bundle\DataBundle\Entity\Promo;

class PromosController extends Controller
{
  public function indexAction()
  {
     //variables de base
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $log = $this->get('logger');
    
    $log->info('Promos : index action');
    $promos = new EntityChoiceList($em,'Ensiie\Bundle\DataBundle\Entity\Promo');
    $form = $this->createFormBuilder();
    $form->add('promo','entity',array(
			 "choices"=>$promos,
			 "class"=>'Ensiie\Bundle\DataBundle\Entity\Promo'
			 ));
    $form = $form->getForm();
    $log->info('Check form');
    if($request->getMethod() == 'POST')
    {
      $form->bind($request);
      if($form->isValid())
      {
	$log->info('GET id + redirection');
	$id = $form["promo"]->getData()->getId();
	return $this->render('EnsiieDataBundle:Promos:index.html.twig',array(
	"form"=>$form->createView(),
	"promo"=>$form["promo"]->getData()->getLibelle(),
	"id"=>$id,
	));
      }
    }
    return $this->render('EnsiieDataBundle:Promos:index.html.twig',array(
    "form"=>$form->createView(),
    "promo"=>"",
    ));
  }
  public function addAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $log = $this->get('logger');
    
    $log->info('Promos : add action');
    $etus = $em->getRepository('EnsiieDataBundle:Etudiant')->findBy(array("promo"=>null));
    $form = $this->createFormBuilder();
    $form->add('etudiant','entity',array(
			 "choices"=>$etus,
			 "class"=>'Ensiie\Bundle\DataBundle\Entity\Etudiant'
			 ));
    $form = $form->getForm();
    
    $log->info('Promos : check form');
    if($request->getMethod() == 'POST')
    {
      $form->bind($request);
      if($form->isValid())
      {
	$etu = $form['etudiant']->getData();
	$promo = $em->getRepository('EnsiieDataBundle:Promo')->find($id);
	$promo->addEtudiant($etu);
	$etu->setPromo($promo);
	$em->persist($promo);
	$em->persist($etu);
	$em->flush();
	$etus = $em->getRepository('EnsiieDataBundle:Etudiant')->findBy(array("promo"=>null));
	$form = $this->createFormBuilder();
	$form->add('etudiant','entity',array(
			    "choices"=>$etus,
			    "class"=>'Ensiie\Bundle\DataBundle\Entity\Etudiant'
			    ));
	$form = $form->getForm();
	return $this->render('EnsiieDataBundle:Promos:add.html.twig',array(
	"id"=>$id,
	"form"=>$form->createView(),
	"success"=>$etu,
	"error"=>''
	));
      }
    }
    return $this->render('EnsiieDataBundle:Promos:add.html.twig',array(
    "id"=>$id,
    "form"=>$form->createView(),
    "success"=>'',
    "error"=>'',
    ));
  }
  public function removeAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $log = $this->get('logger');
    $user = $this->get('security.context')->getToken()->getUser();
    
    $log->info('Promos : remove Action');
    $etus = $em->getRepository('EnsiieDataBundle:Etudiant')->findBy(array("promo"=>$id));
    $form = $this->createFormBuilder();
    $form->add('etudiant','entity',array(
			 "choices"=>$etus,
			 "class"=>'Ensiie\Bundle\DataBundle\Entity\Etudiant'
			 ));
    $form = $form->getForm();
    $log->info('Promos : check form');
    if($request->getMethod() == 'POST')
    {
      $form->bind($request);
      if($form->isValid())
      {
	$etu = $form['etudiant']->getData();
	$promo = $em->getRepository('EnsiieDataBundle:Promo')->find($id);
	$promo->removeEtudiant($etu);
	$etu->setPromo(null);
	$em->persist($etu);
	$em->persist($promo);
	$em->flush();
	
	$etus = $em->getRepository('EnsiieDataBundle:Etudiant')->findBy(array("promo"=>$id));
	$form = $this->createFormBuilder();
	$form->add('etudiant','entity',array(
			    "choices"=> $etus,
			    "class"=>'Ensiie\Bundle\DataBundle\Entity\Etudiant'
			    ));
	$form = $form->getForm();
	return $this->render('EnsiieDataBundle:Promos:remove.html.twig',array(
	"id"=>$id,
	"form"=>$form->createView(),
	"success"=>$etu,
	"error"=>''
	));
      }
    }
    return $this->render('EnsiieDataBundle:Promos:remove.html.twig',array(
    "id"=>$id,
    "form"=>$form->createView(),
    "success"=>'',
    "error"=>'',
    ));
  }
  public function addPromoAction()
  {
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $log = $this->get('logger');
    
    $log->info('add promo action');
    $promo = new Promo;
    $form = $this->createFormBuilder($promo);
    $form->add('libelle','text')
    ->add('annee','number');
    $form = $form->getForm();
    
    $log->info('check method');
     if($request->getMethod() == 'POST')
    {
      $log->info('check form');
      $form->bind($request);
      if($form->isValid())
      {
	$log->info('Test unicité année/nom');
	$test = $em->getRepository('EnsiieDataBundle:Promo')->findOneBy(array("libelle"=>$promo->getLibelle(),'annee'=>$promo->getAnnee()));
	
	if($test != "")
	  return $this->render('EnsiieDataBundle:Promos:addPromos.html.twig',array(
	  "form"=>$form->createView(),
	  "error"=>"Le couple ".$promo->getAnnee()." / ".$promo->getLibelle()." n'est pas unique",
	  "success"=>"",
	 ));
      
	$em->persist($promo);
	$em->flush();

	return $this->render('EnsiieDataBundle:Promos:addPromos.html.twig',array(
	  "form"=>$form->createView(),
	  "error"=>"",
	  "success"=>"La promo ".$promo->getAnnee()." : ".$promo->getLibelle()." a bien été ajoutée !",
	 ));
      }
    }
    
    return $this->render('EnsiieDataBundle:Promos:addPromos.html.twig',array(
      "form"=>$form->createView(),
      "error"=>"",
      "success"=>"",
      ));
  }
  public function removePromoAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $em->remove($em->getRepository('EnsiieDataBundle:Promo')->find($id));
    $em->flush();
    
    return $this->redirect($this->generateUrl('ensiie_admin_promos',array(), 301));
  }
}