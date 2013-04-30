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
use Ensiie\Bundle\DataBundle\Entity\FileExamen;
use Ensiie\Bundle\DataBundle\Form\Type\ExamenType;
use Ensiie\Bundle\DataBundle\Form\Type\FileExamenType;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;

class ExamenController extends Controller
{
  public function affectAction()
  {
    //variables de base
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $logger = $this->get('logger');
    $user = $this->get('security.context')->getToken()->getUser();	
    
    $logger->info('Examen upload : création du formulaire.');
    $examen = new Examen;
    $qb = $em->createQueryBuilder();
    $qb->add('select', 'u')->add('from', 'Ensiie\Bundle\DataBundle\Entity\FileExamen u')->add('where', 'u.user = '.$user->getId());
    
    $promos = new EntityChoiceList($em,'Ensiie\Bundle\DataBundle\Entity\Promo');
    $form = $this->createForm(new ExamenType(), $examen);
    $form->add('file','entity',array (
                            'class' => 'Ensiie\Bundle\DataBundle\Entity\FileExamen',
                            'query_builder' => $qb,
                            'required' => true));
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
  public function showAction($by_owner)
  {
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $logger = $this->get('logger');
    $user = $this->get('security.context')->getToken()->getUser();
    $exams = array();
    $exam_encours = array();
    $exams_list = array();
    $date = new \DateTime();
    
    if($by_owner!="true")
      $exams_list = $em->getRepository("EnsiieDataBundle:Examen")->findBy(array(),array("date_fin"=>"desc"));
    else
    {
      $logger->info("tri par user");
      $files = $em->getRepository("EnsiieDataBundle:FileExamen")->findBy(array("user"=>$user));
      $exams_list_temp = $em->getRepository("EnsiieDataBundle:Examen")->findBy(array(),array("date_fin"=>"desc"));
      foreach($exams_list_temp as $exam)
	foreach($files as $file)
	  if($exam->getFile() == $file)
	    array_push($exams_list,$exam);
    }
    $logger->info("tri d'affichage");
    foreach($exams_list as $exam)
      if($exam->getDateDebut() <= $date && $exam->getDateFin() >= $date)
	array_push($exam_encours,$exam);
      else
	array_push($exams,$exam);
    $logger->info("return");
    return $this->render('EnsiieDataBundle:Examen:show.html.twig',array(
      "exams"=>$exam_encours,
      "exams2"=>$exams,
      "date" => new \Datetime(),
      "user"=>$user,
      ));
  }
  public function removeAction($id)
  {
    
    $logger = $this->get('logger');
    $em = $this->getDoctrine()->getManager();
    $exam = $em->getRepository('EnsiieDataBundle:Examen')->find($id);
    $nom = $exam->getLibelle();
    $logger->info("finded");
    if($exam != "")
    $em->remove($exam); 
    $em->flush();
    $logger->info("deleted");
    return $this->render('EnsiieDataBundle:Examen:remove_success.html.twig',array(
	    "libelle"=>$nom,
	    ));
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
      $user = $this->get('security.context')->getToken()->getUser();
       $promos = new EntityChoiceList($em,'Ensiie\Bundle\DataBundle\Entity\Promo');
      
      $qb = $em->createQueryBuilder();
      $qb->add('select', 'u')->add('from', 'Ensiie\Bundle\DataBundle\Entity\FileExamen u')->add('where', 'u.user = '.$user->getId());
      $form = $this->createForm(new ExamenType(), $exam);
      $form->add('file','entity',array (
                            'class' => 'Ensiie\Bundle\DataBundle\Entity\FileExamen',
                            'query_builder' => $qb,
                            'required' => true));
      $form->add('promo','choice',array(
	'choice_list' => $promos,
      'required' => false,
      'empty_value' => 'Choisir une promo',
      'empty_data'  => null))
      ;
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
	    "form"=>$form->createView(),
	    "id"=>$id,
	    ));
	}
	return $this->render('EnsiieDataBundle:Examen:modif2.html.twig',array(
	    "error"=>"Formulaire invalide.",
	    "success"=>"",
	    "form"=>$form->createView(),
	    "id"=>$id,
	    ));
      }
      return $this->render('EnsiieDataBundle:Examen:modif2.html.twig',array(
	    "error"=>"",
	    "success"=>"",
	    "form"=>$form->createView(),
	    "id"=>$id,
	    ));
    }
    
    public function ajoutEtuAction($id)
    {
      $logger = $this->get('logger');
      $logger->info('Modif etu action');
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager();
     
      $logger->info('Get examen');
      $examen = $em->getRepository("EnsiieDataBundle:Examen")->find($id);
      
      $logger->info('On récupère l\'ID de la promo en cours.');
      $promo_id = $examen->getPromo()->getId();
      
      $logger->info('form ajout');
      
      $etudiants =array();
      //PUR BRICOLAGE
      $etudiants1 = $em->getRepository("EnsiieDataBundle:Etudiant")->findAll();
      $etudiants2 = $em->getRepository("EnsiieDataBundle:Etudiant")->findBy(array("promo" => $examen->getPromo()));  
      foreach($etudiants1 as $etu1)
      {
	$i =0;
	foreach($etudiants2 as $etu2)
	  if($etu1 == $etu2)
	    $i = 1;
	foreach($examen->getEtudiants() as $etu2)
	    if($etu1 == $etu2)
	      $i = 1;
	if($i==0)
	  array_push($etudiants,$etu1);
      }
      //FIN PUR BRICOLAGE
      $form_ajout = $this->createFormBuilder($examen);
      $form_ajout->add('etudiants','entity',array (
                            'class' => 'Ensiie\Bundle\DataBundle\Entity\Etudiant',
                            'choices' => $etudiants,
                            'required' => true));
                            
      $form_ajout = $form_ajout->getForm();
      
      $logger->info('Check method');
      if($request->getMethod() == 'POST')
      {
	$logger->info('Check form_ajout');
	$form_ajout->bind($request);
	if($form_ajout->isValid())
	{
	  $em->persist($examen);
	  $em->flush();
	  $logger->info('Modif done.');
	  
	  return $this->redirect($this->generateUrl('ensiie_examen_ajouter_etu',array("id"=>$id), 301));
	}
      }
      return $this->render('EnsiieDataBundle:Examen:ajouter_etu.html.twig',array(
	"error"=>"",
	"success"=>"",
	"form_ajout"=> $form_ajout->createView(),
	));
    }
    public function retraitEtuAction($id)
    {
      $logger = $this->get('logger');
      $logger->info('Modif etu action');
      $request = $this->get('request');
      $em = $this->getDoctrine()->getManager();
     
      $logger->info('Get examen');
      $examen = $em->getRepository("EnsiieDataBundle:Examen")->find($id);
      
      $logger->info('On récupère l\'ID de la promo en cours.');
      $promo_id = $examen->getPromo()->getId();
      
      $logger->info('form ajout');
      
      $etudiants =array();

      $etudiants = $examen->getEtudiants();      
      $form = $this->createFormBuilder($examen);
      $form->add('etudiants','entity',array (
                            'class' => 'Ensiie\Bundle\DataBundle\Entity\Etudiant',
                            'choices' => $etudiants,
                            'required' => true));            
      $form = $form->getForm();
      
      $logger->info('Check method');
      if($request->getMethod() == 'POST')
      {
	$logger->info('Check form_ajout');
	$form->bind($request);
	if($form->isValid())
	{
	  $etu;
	  foreach($examen->getEtudiants() as $etu);
	  //PATCH
	  $examen->removeEtudiant($etu);
	  $examen->removeEtudiant($etu);
	  $em->persist($examen);
	  $em->flush();
	  
	  $examen = $em->getRepository("EnsiieDataBundle:Examen")->find($id);
	  $logger->info('Modif done.');
	  return $this->redirect($this->generateUrl('ensiie_examen_retirer_etu',array("id"=>$id), 301));
	}
	$logger->info('Check form_retirer');
      }
      return $this->render('EnsiieDataBundle:Examen:retirer_etu.html.twig',array(
	"error"=>"",
	"success"=>"",
	"form"=>$form->createView(),
	));
    }
}
