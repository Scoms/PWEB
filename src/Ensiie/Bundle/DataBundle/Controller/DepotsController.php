<?php

namespace Ensiie\Bundle\DataBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Ensiie\Bundle\DataBundle\Entity\Depot;

class DepotsController extends Controller
{
  public function showAction($id,$dpt)
  {
    $em = $this->getDoctrine()->getManager();
    $request = $this->get('request');
    $log = $this->get('logger');
    
    $log->info('Depot controller show action. Get dépots.');
    $depots = $em->getRepository('EnsiieDataBundle:Depot')->findBy(array("examen"=>$id));
    $log->info('Création de formulaires');
    $depots_entity = array();
    foreach($depots as $depot)
    {
      $depot_entity[$depot->getId()] = $depot;
      $form = $this->createFormBuilder($depot);
      $form->add('note','number',array(
	'invalid_message'            => 'La valeur rentrée ne paraît pas très cohérente monsieur !!!',
      ));
      $form = $form->getForm();
      $depots_entity[$depot->getId()] = $form;
    }
    
    $log->info("Analyse de la requete");
    if($request->getMethod() == 'POST')
      {
	$log->info('Check form');
	$depots_entity[$dpt]->bind($request);
	$em->persist($depot_entity[$dpt]);
	$em->flush();
	$log->info('Note done.');
	return $this->render('EnsiieDataBundle:Depots:index.html.twig',array(
	  "depots"=>$depots,
	  "array_form"=>$depots_entity,
	  "msg"=>"",
	  "id"=>$id,
	  ));
      }
    return $this->render('EnsiieDataBundle:Depots:index.html.twig',array(
      "depots"=>$depots,
      "array_form"=>$depots_entity,
      "msg"=>"",
      "id"=>$id,
      ));
  }
}

?>