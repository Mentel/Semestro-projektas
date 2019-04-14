<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setCreatedAt();


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/user/delete/{max}", name="delete")
     */
    public function delete($max)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(User::class)
            ->findAll();
        foreach($repository as &$a)
        {
            $entityManager->remove($a);
        }
        $entityManager->flush();
        return new Response('Saved new product with id 1');
    }

    /**
     * @Route("/user/all/{all}", name="all")
     */
    public function all($all)
    {
        $repository = $this->getDoctrine()->getRepository(User::class)
            ->findAll();
        foreach($repository as &$a)
        {
            $a->getEmail();
            echo "<br>";
            echo $a->getEmail();
            foreach($a->getRoles() as &$b){
                echo "<br>";
                echo "role";
                echo $b;
            }
        }
        echo "<br>";
        return new Response('nic');

    }
}
