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

class ChangePasswordController extends AbstractController
{
    /**
     * @Route("/settings/changepassword", name="app_changepassword")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenStorageInterface $tokenStorage, \Swift_Mailer $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $data = $form->getData();
            $user = $tokenStorage->getToken()->getUser();
            $checkPass = $passwordEncoder->isPasswordValid($user, $data['oldPassword']);
            if ($checkPass === true)
            {
                $new_pwd_encoded = $passwordEncoder->encodePassword($user, $data['newPassword']);
                $user->setPassword($new_pwd_encoded);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $message = (new \Swift_Message('Jūsų slaptažodis buvo pakeistas'))
                    ->setFrom('datadogprojektas@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody(
                        $this->renderView(
                            'email/changepassword.html.twig',
                            ['name' => $user->getEmail()]
                        ),
                        'text/html'
                    );

                $mailer->send($message);

                return $this->redirectToRoute('app_index');
            }
            else
            {
                return $this->render('security/changepassword.html.twig', [
                    'changepasswordForm' => $form->createView(),
                    'error' => 'Neteisingas slaptažodis',
                ]);
            }
        }

        return $this->render('security/changepassword.html.twig', [
            'changepasswordForm' => $form->createView(),
            'error' => '',
        ]);
    }
}
