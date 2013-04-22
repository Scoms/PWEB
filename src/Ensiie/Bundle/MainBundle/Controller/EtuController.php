<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EtuController extends Controller
{
    public function indexAction()
    {
        return $this->render('EnsiieMainBundle:Etu:index.html.twig');
    }
}
