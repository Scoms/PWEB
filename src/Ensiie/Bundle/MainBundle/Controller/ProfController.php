<?php

namespace Ensiie\Bundle\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ensiie\Bundle\DataBundle\Entity\Examen;
use Ensiie\Bundle\DataBundle\Entity\FileExamen;

class ProfController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateURL('ensiie_examen_show',array("by_owner"=>"true"),301));
    }
}
