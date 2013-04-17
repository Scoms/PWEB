<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfController extends Controller
{
    public function indexAction()
    {
        return $this->render('EnsiieMainBundle:Prof:index.html.twig');
    }
}
