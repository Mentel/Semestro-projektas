<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventController extends AbstractController
{
    /**
     * @Route("/event/add", name="events")
     */
    public function index(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $usr = $this->get('security.token_storage')->getToken()->getUser();

        $eventVar = new Event();
        $eventVar->setName("Iveskite renginio pavadinima");
        $eventVar->setHost($usr);
        $eventVar->setDescription("Iveskite renginio aprasyma");
        $eventVar->setDate(new \DateTime('now'));
        $eventVar->setAddress("Iveskite renginio adresa");

        $form = $this->createFormBuilder($eventVar)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('date', DateTimeType::class)
            ->add('address', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Sukurti rengini'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $eventVar = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($eventVar);
             $entityManager->flush();

            return $this->redirectToRoute('events_all');
        }

        return $this->render('event/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/events", name="events_all")
     */
    public function all()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();
            //echo $a->getDate()->format('Y-m-d H:i:s');
        return $this->render('event/list.html.twig', ['events' => $events]);
    }
}
