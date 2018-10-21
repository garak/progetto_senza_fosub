<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods="GET")
     */
    public function homepage(): Response
    {
        return $this->render('default/homepage.html.twig');
    }
}
