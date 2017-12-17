<?php

namespace FS\FsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FsBundle:Default:index.html.twig');
    }
}
