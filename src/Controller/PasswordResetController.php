<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\Model\ChangePasswordModel;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PasswordResetController extends AbstractController
{
    /**
     * @Route("/settings/resetemail", name="app_reset_send")
     */
    public function sendResetEmail(Request $request, TokenStorageInterface $tokenStorage, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ResetFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $usr = $entityManager->getRepository(User::class)
                ->findOneBy(['email' => $data['email']]);
            if ($usr != null) {
                $s = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 5);
                $usr->setVerify($s);
                $entityManager->flush();


                return new Response('issiusta');
            }
            else{
                return new Response('nerastas email');
            }
        }
    }
}
