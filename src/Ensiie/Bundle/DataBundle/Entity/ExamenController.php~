<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ensiie\Bundle\DataBundle\Entity\Examen;
use Ensiie\Bundle\DataBundle\Entity\FileExamen;

class ExamenController extends Controller
{
    public function indexAction()
    {
	$document = new FileExamen();
    $form = $this->createFormBuilder($document)
        ->add('name')
        ->add('file')
        ->getForm()
    ;

    if ($this->getRequest()->isMethod('POST')) {
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
	    
	    $document->upload();
	    
            $em->persist($document);
            $em->flush();
        }
    }
        return $this->render('EnsiieMainBundle:Prof:index.html.twig',array(
        'form' => $form->createView()
        ));
    }
}
