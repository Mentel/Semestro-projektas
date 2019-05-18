<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\EventAddFormType;
use App\Form\EventFilterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


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
        $price=100;
        $start=new \DateTime('now');
        $interval = new \DateInterval('P1Y');
        $session = new Session();
        $session->remove('date');
        $session->remove('dateTo');
        $session->remove('price');
        $session->remove('category');
        return $this->redirectToRoute('app_event_list_filter',
            array('page' => 1));
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
     * @Route("/events/list/{page}", name="app_event_list_filter")
     */
    public function listEventsN($page, Request $request)
    {
        $session = new Session();

        $form = $this->createForm(EventFilterFormType::class);
        $form->handleRequest($request);

        if ($form->get('filter')->isClicked()) {
            $session->set('date', $form->get('date')->getData());
            $session->set('dateTo', $form->get('dateTo')->getData());
            $session->set('price', $form->get('price')->getData());
            $session->set('category', $form->get('category')->getData());
            return $this->redirectToRoute('app_event_list_filter',
                array('page' => 1));
        }

        $form->get('date')->setData($session->get('date'));
        $form->get('dateTo')->setData($session->get('dateTo'));
        $form->get('price')->setData($session->get('price'));
        if ($session->has('category'))
            $form->get('category')->setData($session->get('category'));


        if (!$form->get('price')->isEmpty()) {
            $price = $form->get('price')->getData();
            $session->set('price', $price);
        } else {
            if ($session->has('price'))
                $session->remove('price');
            $price = 10000000;
        }

        if (!$form->get('date')->isEmpty()) {
            $date = $form->get('date')->getData();
            $session->set('date', $date);
        } else {
            if ($session->has('date'))
                $session->remove('date');
            $date = new \DateTime('2013-01-01');
        }

        if (!$form->get('dateTo')->isEmpty()) {
            $dateTo = $form->get('dateTo')->getData();
            $session->set('dateTo', $dateTo);
        } else {
            if ($session->has('dateTo'))
                $session->remove('dateTo');
            $now = new \DateTime('now');
            $dateTo = $now->add(new \DateInterval('P50Y'));
        }

        if ($session->has('category')) {
            if (!(count($form->get('category')->getData())) < 1) {
                $category = $form->get('category')->getData();
                $session->set('category', $dateTo);
            } else {
                if ($session->has('category'))
                    $session->remove('category');
                $category = null;
            }
        }
        $count = $this->getDoctrine()->getRepository(Event::class)->count(array());
        if (!$session->has('category')) {
            $event = $this->getDoctrine()->getRepository(Event::class)->findByDate($date, $dateTo, $price, $count , 0);
            $size = count($event);
        } else {
            $event = $this->getDoctrine()->getRepository(Event::class)->findFilter($date, $dateTo, $price, $category, $count, 0);
            $size = count($event);
        }

        $limit = 5;
        $pageCount = ceil($size / $limit);
        if($pageCount==0)
            $pageCount=1;
        if ($page < 1 || $page > $pageCount) {
            return $this->redirectToRoute('app_event_list_filter', array('page' => 1));
        }
        $offset = ($page - 1) * $limit;

        if (!$session->has('category')) {
            $event = $this->getDoctrine()->getRepository(Event::class)->findByDate($date, $dateTo, $price, $limit, $offset);
        } else {
            $event = $this->getDoctrine()->getRepository(Event::class)->findFilter($date, $dateTo, $price, $category, $limit, $offset);
        }

        return $this->render('event/filter.html.twig', ['events' => $event, 'pageNumber' => $page, 'pageCount' => $pageCount, 'eventListForm' => $form->createView()]);
    }
    /**
     * @Route("event/edit/{id}", name="app_event_edit")
     */
    public function eventEdit(Request $request, $id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $event = $this->getDoctrine()->getRepository(Event::class)->find($id);

        if(!$event)
        {
            throw $this->createNotFoundException(
                'Klaida: Nėra renginio su id ' .$id
            );
        }

        $form = $this->createForm(EventAddFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->get('security.token_storage')->getToken()->getUser();
            $data = $form->getData();

            $event->setHost($user);
            $event->setName($data['name']);
            $event->setDate($data['date']);
            $event->setAddress($data['address']);
            $event->setPrice($data['price']);
            $event->setDescription($data['description']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('app_event_list_paging', array('page' => 1));
        }

        return $this->render('event/edit.html.twig', [
            'eventAddForm' => $form->createView()
        ]);

    }
}
