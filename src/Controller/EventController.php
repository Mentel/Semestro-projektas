<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EventAddFormType;
use App\Form\EventFilterFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{
    /**
     * @Route("/event/add", name="app_event_add")
     */
    public function addEvent(Request $request, \Swift_Mailer $mailer)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $form = $this->createForm(EventAddFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $data = $form->getData();

            if(count($data['categories']) < 1){
                return $this->render('event/add.html.twig', [
                    'eventAddForm' => $form->createView(),
                    'message' => 'Pasirinkite bent vieną kategoriją'
                ]);
            }

            $event = new Event();

            $event->setHost($user);
            $event->setName($data['name']);
            $event->setDate($data['date']);
            $event->setAddress($data['address']);
            $event->setPrice($data['price']);
            $event->setDescription($data['description']);
            foreach ($data['categories'] as $category){
                $event->addCategory($category);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            //Email siuntimas tiem kas prenumeravo renginio kategorijas

            $accountsSent = array();
            $categories = $event->getCategory();
            foreach ($categories as $category){
                $users = $category->getUser();
                foreach ($users as $usr){
                    if(!in_array($usr->getEmail(), $accountsSent)){

                        $message = (new \Swift_Message('Įdėtas naujas renginys kuris gali jus sudominti!'))
                            ->setFrom('datadogprojektas@gmail.com')
                            ->setTo($usr->getEmail())
                            ->setBody(
                                $this->renderView(
                                    'email/eventaddsubscribed.html.twig',
                                    ['name' => $event->getName(), 'id' => $event->getId()]
                                ),
                                'text/html'
                            );
                        $mailer->send($message);

                        $accountsSent[] = $usr->getEmail();
                    }
                }
            }

            return $this->redirectToRoute('app_event_list_paging', array('page' => 1));
        }

        return $this->render('event/add.html.twig', [
            'eventAddForm' => $form->createView(),
            'message' => ''
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
        $length = 5;
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
                'categories' => $event->getCategory(),
                'id' => $id
                ]
            );
        }
        return $this->redirectToRoute('app_event_list_paging', array('page' => 1));
    }
    /**
     * @Route("/event/delete/{id}", name="app_event_delete")
     */
    public function eventDelete($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');

        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)
            ->find($id);
        if($event != null){
            $entityManager->remove($event);
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_event_list_paging', array('page' => 1));
    }
    /**
     * @Route("/events/{dateStart}/{dateEnd}/{price}/{page}", name="app_event_list_filter")
     */
    public function listEventsN($page, $dateStart, $dateEnd, Request $request, $price)
    {
        $form = $this->createForm(EventFilterFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $start = $form->get('date')->getData();
            $end = $form->get('dateTo')->getData();
            $price = $form->get('price')->getData();
            return $this->redirectToRoute('app_event_list_filter',
                array('page' => 1,
                    'price' => $price,
                    'dateStart' => $start->format('Y-m-d'),
                    'dateEnd' => $end->format('Y-m-d') ));
        }

        $length = 5;
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


        $start = new \DateTime($dateStart);
        $end = new \DateTime($dateEnd);
        $form->get('date')->setData($start);
        $form->get('dateTo')->setData($end);
        $form->get('price')->setData($price);

        $event=$this->getDoctrine()->getRepository(Event::class)->findByDate($start, $end, $price);




        $offset = ($page - 1)* $length;
        $eventManager = $this->getDoctrine()->getManager();
        return $this->render('event/filter.html.twig', ['events' => $event, 'pageNumber' => $page, 'pageCount' => $pageCount, 'eventListForm' => $form->createView()]);
    }
}
