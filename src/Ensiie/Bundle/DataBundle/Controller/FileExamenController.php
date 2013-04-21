<?php

namespace Ensiie\Bundle\DataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ensiie\Bundle\DataBundle\Form\Type\FileExamenType;
use Ensiie\Bundle\DataBundle\Entity\FileExamen;

class FileExamenController extends Controller
{
    public function uploadAction()
    {
	//variables de base
	$em = $this->getDoctrine()->getManager();
	$request = $this->get('request');
	$logger = $this->get('logger');
	
	$logger->info('FileExamen upload : création du formulaire.');
	$document = new FileExamen;
	$form = $this->createForm(new FileExamenType(), $document);
	$logger->info('Examen upload : vérification de la method post.');
	if($request->getMethod() == 'POST')
	{
	  $form->bind($request);
	  $logger->info('Examen upload : form binded.');
	  if($form->isValid())
	  {
	    $logger->info('Examen upload : form valid.');
	    $em = $this->getDoctrine()->getManager();
	    $document->upload();
	    $em->persist($document);
	    $em->flush();
	  }	
	}
        return $this->render('EnsiieDataBundle:FileExamen:add.html.twig',array(
	  "form" => $form->createView(),
	  ));
    }
    public function showAction()
    {
      //variables de base
      $em = $this->getDoctrine()->getManager();
      $request = $this->get('request');
      $logger = $this->get('logger');

      $logger->info('FileExamen show : récupération de tout les fichiers d\'éxamens.');
      $list_exam = $em->getRepository('EnsiieDataBundle:FileExamen')->findAll();
      
      return $this->render('EnsiieDataBundle:FileExamen:show.html.twig',array(
	  "list" => $list_exam,
	  ));
    }
    public function downloadAction($path)
    {    
      $fichier = "nomFichier.pdf";
      $chemin = "bundles/nomBundle/.../"; // emplacement de votre fichier .pdf    
      $response = new Response();
      $response->setContent(file_get_contents($path));
      $response->headers->set('Content-Type', 'application/force-download'); // modification du content-type pour forcer le téléchargement 	(sinon le navigateur internet essaie d'afficher le document)
	$response->headers->set('Content-disposition', 'filename='. $fichier);
	    
	return $response;
    }
}