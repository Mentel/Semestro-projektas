<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function renderPage()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/ah/{slug}")
     */
    public function renderPage2($slug)
    {
        return new Response(sprintf('URL: %s', $slug));
    }
}