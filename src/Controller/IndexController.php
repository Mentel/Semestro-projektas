<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function renderIndex()
    {
        return $this->render('index.html.twig');
    }
}