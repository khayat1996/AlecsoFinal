<?php

namespace Alecso\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        echo 'Hello User';
        return $this->render('@AlecsoUser/Default/index.html.twig');
    }
}
