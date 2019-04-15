<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

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
     * @Route("/f")
     */
    public function renderDFDF()
    {
        $entityVaflis = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return new Response(
            '<html>Labas</html>'
        );
    }
}