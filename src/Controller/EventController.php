<?php

namespace App\Controller;

use App\Form\EventAddFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;

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
            $event->setPrice($data['price']);
            $event->setDescription($data['description']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_list_paging', array('page' => 1));
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
        return $this->redirectToRoute('app_event_list_paging', array('page' => 1));
    }
    /**
     * @Route("/events/{page}", name="app_event_list_paging")
     */
    public function listEvents($page)
    {
        $length = 10;
        $size = $this->getDoctrine()->getRepository(Event::class)->count(array());
        $pageCount = ceil($size / $length);
        if ($size == 0)
        {
            return $this->redirectToRoute('app_index');
        }
        if ($page < 1 || $page > $pageCount)
        {
            return $this->redirectToRoute('app_event_list_paging', array('page' => 1));
        }

        $offset = ($page - 1)* $length;
        $events = $this->getDoctrine()->getRepository(Event::class)->findBy(array(), array('date' => 'DESC'), $length, $offset);
        return $this->render('event/list.html.twig', ['events' => $events, 'pageNumber' => $page, 'pageCount' => $pageCount]);
    }
    /**
     * @Route("/event/{id}", name="app_event")
     */
    public function eventView($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)
            ->find($id);
        if($event!=null) {
            return $this->render('event/detail.html.twig',
                ['name' => $event->getName(),
                'address' => $event->getAddress(),
                'description' => $event->getDescription(),
                'date' => $event->getDate(),
                'price' => $event->getPrice(),
                'categories' => $event->getCategory()
                ]
            );
        }
        return $this->redirectToRoute('app_event_list_paging', array('page' => 1));
    }

}
