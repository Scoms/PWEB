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
use Ensiie\Bundle\DataBundle\Form\Type\ExamenType;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;

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
    $files = new EntityChoiceList($em,'Ensiie\Bundle\DataBundle\Entity\FileExamen');
    $promos = new EntityChoiceList($em,'Ensiie\Bundle\DataBundle\Entity\Promo');
    $form = $this->createForm(new ExamenType(), $examen);
    $form->add('file','choice',array('choice_list'=> $files));
    $form->add('promo','choice',array(
      'choice_list' => $promos,
    'required' => false,
    'empty_value' => 'Choisir une promo',
    'empty_data'  => null))
    ;
    
    $logger->info('Examen upload : vérification de la method post.');
    if($request->getMethod() == 'POST')
    {
      $form->bind($request);
      $logger->info('Examen upload : form binded.');
      if($form->isValid())
      {
	$logger->info('Examen upload : form valid.');
	$em = $this->getDoctrine()->getManager();
	
	$logger->info("L'unicité promo/file_id");
	$test = $em->getRepository("EnsiieDataBundle:Examen")->findOneBy(array("file" => $document->getFile(),"promo"=>$document->getPromo()));
	    if($test != "")
	    {
		  return $this->render('EnsiieDataBundle:Examen:upload.html.twig',array(
		  "form" => $form->createView(),
		  "success" => "",
		  "error" => "Examen déjà existant.",
		  ));
	    }
	$em->persist($examen);
	$em->flush();
	return $this->render('EnsiieDataBundle:Examen:upload.html.twig',array(
	  "form" => $form->createView(),
	  "error"=>"",
	  "success"=>"L'examen ".$examen->getLibelle()."à bien été ajouté !",
	  ));
      }	
    }
    
    return $this->render('EnsiieDataBundle:Examen:upload.html.twig',array(
      "form" => $form->createView(),
      "error"=>"",
      "success"=>"",
      ));
  }
  public function showAction()
  {
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $logger = $this->get('logger');
    $exams = array();
    $exam_encours = array();
    $date = new \DateTime();
    
    $exams_list = $em->getRepository("EnsiieDataBundle:Examen")->findBy(array(),array("date_fin"=>"desc"));
    foreach($exams_list as $exam)
    {
      if($exam->getDateDebut() <= $date && $exam->getDateFin() >= $date)
      {
	array_push($exam_encours,$exam);
      }
      else
      {
	array_push($exams,$exam);
      }
    }
    return $this->render('EnsiieDataBundle:Examen:show.html.twig',array(
      "exams"=>$exam_encours,
      "exams2"=>$exams,
      "date" => new \Datetime(),
      ));
  }
  public function removeAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $exam = $em->getRepository('EnsiieDataBundle:Examen')->find($id);
    if($exam != "")
    $em->remove($exam); 
    $em->flush();
    return $this->showAction();
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