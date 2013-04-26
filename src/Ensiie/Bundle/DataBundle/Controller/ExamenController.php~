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
    
    $logger = $this->get('logger');
    $em = $this->getDoctrine()->getManager();
    $exam = $em->getRepository('EnsiieDataBundle:Examen')->find($id);
    $logger->info("finded");
    if($exam != "")
    $em->remove($exam); 
    $em->flush();
    $logger->info("deleted");
    return $this->showAction();
  }
  public function modifAction()
  {
    $logger = $this->get('logger');
    $user = $this->get('security.context')->getToken()->getUser();
    $em = $this->getDoctrine()->getManager();
    $exams = $em->getRepository("EnsiieDataBundle:Examen")->findAll();
    $date = new \DateTime();
    
      $logger->info("ID NULL");
      return $this->render('EnsiieDataBundle:Examen:modif.html.twig',array(
	"exams"=>$exams,
	"user"=>$user,
	"date"=>$date
	));
      
    }
    public function modifIDAction($id)
    {
      $logger = $this->get('logger');
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager();
      $exam = $em->getRepository("EnsiieDataBundle:Examen")->find($id);
      $form = $this->createForm(new ExamenType(), $exam);
      
      $logger->info('Check method');
      if($request->getMethod() == 'POST')
      {
	$form->bind($request);
	$logger->info('form binded.');
	if($form->isValid())
	{
	  $em->persist($exam);
	  $em->flush();
	  $logger->info('Modif done.');
	  return $this->render('EnsiieDataBundle:Examen:modif2.html.twig',array(
	    "error"=>"",
	    "success"=>"Examen modifié avec succès.",
	    "form"=>$form->createView()
	    ));
	}
	return $this->render('EnsiieDataBundle:Examen:modif2.html.twig',array(
	    "error"=>"Formulaire invalide.",
	    "success"=>"",
	    "form"=>$form->createView()
	    ));
      }
      return $this->render('EnsiieDataBundle:Examen:modif2.html.twig',array(
	    "error"=>"",
	    "success"=>"",
	    "form"=>$form->createView()
	    ));
    }
}
