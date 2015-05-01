<?php

namespace SP\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use symfony\Component\HttpFoundation\Response;

class WelcomeController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SPPlatformBundle:Default:index.html.twig', array('name' => $name));
    }
}
