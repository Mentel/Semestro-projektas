<?php

namespace App\Controller;

use App\Form\EventAddFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventController extends AbstractController
{
    /**
     * @Route("/event/add", name="app_event_add")
     */
    public function addEvent(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $form = $this->createForm(EventAddFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $data = $form->getData();

            $event = new Event();

            $event->setHost($user);
            $event->setName($data['name']);
            $event->setDate($data['date']);
            $event->setAddress($data['address']);
            $event->setDescription($data['description']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_list');
        }

        return $this->render('event/add.html.twig', [
            'eventAddForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/events", name="app_event_list")
     */
    public function listAllEvents()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->render('event/list.html.twig', ['events' => $events]);
    }
    /**
     * @Route("/event/{id}", name="app_event")
     */
    public function eventView()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
        return $this->render('event/list.html.twig', ['events' => $events]);
    }

}
