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
    
    $log->info('Depot controller show action');
    $log->info(' Get dépots.');
    $depots = $em->getRepository('EnsiieDataBundle:Depot')->findBy(array("examen"=>$id));
    
    $log->info("Nombre d'inscrits");
    $examen = $em->getRepository('EnsiieDataBundle:Examen')->find($id);
    $inscrits["supp"] = count($examen->getEtudiants());
    $inscrits["promo"] = count($examen->getPromo()->getEtudiant());
    
    $log->info("Nombre de dépots");
    $nb_depots = count($depots);
    
    $log->info('calcul de la moyenne');
    $moyenne = 0;
    $i=0;
    $log->info('Création de formulaires');
    $depots_entity = array();
    foreach($depots as $depot)
    {
      if($depot->getNote()!=null)
      {
	$moyenne += $depot->getNote();
	$i++;
      }
      $depot_entity[$depot->getId()] = $depot;
      $form = $this->createFormBuilder($depot);
      $form->add('note','number',array(
	'invalid_message'            => 'La valeur rentrée ne paraît pas très cohérente monsieur !!!',
	'precision'=>2,
      ));
      $form = $form->getForm();
      $depots_entity[$depot->getId()] = $form;
    }
    if($i !=0)
      $moyenne = $moyenne / $i;

    $log->info("Analyse de la requete");
    if($request->getMethod() == 'POST')
      {
	$log->info('Check form');
	$depots_entity[$dpt]->bind($request);
	//if($depots_entity[$dpt]->isValid())
        //{
            $em->persist($depot_entity[$dpt]);
            $em->flush();
            $log->info('Note done.');
            return $this->redirect($this->generateUrl('ensiie_examen_depots_consulter',array("id"=>$id,"dpt"=>$dpt), 301));
     //   }
       }
    return $this->render('EnsiieDataBundle:Depots:index.html.twig',array(
      "depots"=>$depots,
      "array_form"=>$depots_entity,
      "msg"=>"",
      "id"=>$id,
      "inscrits"=>$inscrits,
      "nb_depots"=>$nb_depots,
      "moyenne"=>$moyenne,
      ));
  }
}

?>