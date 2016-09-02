<?php

namespace UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('layout/index.html.twig');
    }

    public function dashboardAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('UsersBundle:dashboard:index.html.twig');
    }
}
