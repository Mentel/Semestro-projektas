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
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
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
            $user->setRoles(['ROLE_VERIFIEDNT']);
            $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
            $user->setVerify($s);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'email/registration.html.twig',
                        ['verCode' => $user->getVerify(),
                            'id' => $user->getId()]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

            return $this->render('registration/confirm.html.twig', [
                'email' => $user->getEmail()
            ]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/register/confirm/{id}/{code}", name="app_mail_confirmation")
     */
    public function Confirm($id, $code)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usr = $entityManager->getRepository(User::class)
            ->find($id);
        if ($usr!=null){
            if ($usr->getVerify() != 'NULL') {
                if ($code === $usr->getVerify()) {
                    $usr->setRoles(['ROLE_USER']);
                    $usr->setVerify('NULL');
                    $entityManager->flush();
                }
            }
        }
        return $this->redirectToRoute('app_login');
    }

}
