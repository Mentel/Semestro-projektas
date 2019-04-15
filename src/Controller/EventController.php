<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Response;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     */
    public function index()
    {

        $user = new Event();
        // encode the plain password
        $user->setAdress("asfd");
        $user->setDate(new \DateTime('now'));
        $user->setDescription("eik nx tadai");
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $user->setHost($usr);
        $user->setName("asfd");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        echo 'nice';
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    /**
     * @Route("/event/all", name="event_all")
     */
    public function all()
    {
        $repository = $this->getDoctrine()->getRepository(Event::class)
            ->findAll();
        foreach($repository as &$a)
        {
            echo "<br>";
            echo $a->getDate()->format('Y-m-d H:i:s');

        }
        echo "<br>";
        return new Response('nice :)');

    }
}
