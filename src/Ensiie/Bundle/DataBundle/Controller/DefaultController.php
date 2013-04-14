<?php

namespace Ensiie\Bundle\DataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EnsiieDataBundle:Default:index.html.twig', array('name' => $name));
    }
}
