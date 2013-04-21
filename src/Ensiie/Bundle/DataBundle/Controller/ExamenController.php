<?php
namespace Ensiie\Bundle\DataBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ensiie\Bundle\DataBundle\Entity\Examen;

class ExamenController extends Controller
{
  public function affectAction()
  {
    //variables de base
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $logger = $this->get('logger');
    
    $logger->info('Examen upload : création du formulaire.');
    $examen = new Examen;
    $form = $this->createForm(new ExamenType(), $examen);
    $logger->info('Examen upload : vérification de la method post.');
    if($request->getMethod() == 'POST')
    {
      $form->bind($request);
      $logger->info('Examen upload : form binded.');
      if($form->isValid())
      {
	$logger->info('Examen upload : form valid.');
	$em = $this->getDoctrine()->getManager();
	//$examen->upload();
	$em->persist($document);
	$em->flush();
      }	
    }
    
    return $this->render('EnsiieDataBundle:Examen:upload.html.twig',array(
      "form" => $form->createView()
      ));
  }
	public function addSujetAction() 
	{
		$objSujet = new Sujet();
		$formBuilder = $this->createFormBuilder($objSujet);
		$formBuilder
		   ->add('libelle', 'text')
		   ->add('description', 'text')
		   ->add('promo','integer')
		   ->add('date','datetime')
		   ->add('coefficient','intger') 
		   ->getForm();
		$form = $formBuilder->getForm();
		$request = $this -> get('request');
		if ($request->isMethod('POST')) { $form->bind($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($objSujet);
				$em->flush();
			return new Response('Sujet créé avec id '.$objSujet->getId()); 
			}
		}
		return $this->render('EnsiieMainBundle:Sujet:add.html.twig',array('form'=> $form->createView(),
			));
	}

	public function showSujetAction($id) 
	{
		$objSujet = $this->getDoctrine()->getRepository('EnsiieMainBundle:Sujet')->find($id);
		if (!$objSujet) {
			throw $this->createNotFoundException('Sujet introuvable '.$id);
		}
		return $this->render('EnsiieMainBundle:Sujet:show.html.twig', array('sujet' => $objSujet));
	}
	public function deleteSujetAction($id) 
	{
		$entityManager = $this->getDoctrine()->getManager();
		$objSujet = $entityManager->getRepository('EnsiieMainBundle:Sujet')->find($id);
		if (!$objSujet) {
		throw $this->createNotFoundException('Sujet introuvable '.$id);
		}
		$entityManager->remove($objSujet); $entityManager->flush();
		return new Response('Supression du sujet '.$objSujet->getId()); 
	}
}