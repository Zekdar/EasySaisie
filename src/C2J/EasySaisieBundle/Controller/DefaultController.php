<?php

namespace C2J\EasySaisieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('C2JEasySaisieBundle:Default:index.html.twig');
    }
}
