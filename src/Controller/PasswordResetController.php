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

                $message = (new \Swift_Message('Password reset'))
                    ->setFrom('send@example.com')
                    ->setTo($usr->getEmail())
                    ->setBody(
                        $this->renderView(
                        // templates/emails/registration.html.twig
                            'email/reset.html.twig',
                            ['verCode' => $usr->getVerify(),
                                'id' => $usr->getId()]
                        ),
                        'text/html'
                    )
                ;
                $mailer->send($message);

                return $this->render('reset/resetconfirm.html.twig', [
                    'email' => $usr->getEmail()
                ]);
            }
            else{
                return new Response('nerastas email');
            }
        }
        return $this->render('reset/resetemail.html.twig', [
            'resetForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/settings/resetemail/{id}/{code}", name="app_reset")
     */
    public function resetEmail(Request $request, $id, $code, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $usr = new User();
        $usr = $entityManager->getRepository(User::class)
            ->find($id);


        if($usr != null) {
            $form = $this->createForm(ResetNewFormType::class);
            $form->handleRequest($request);
            if($usr->getVerify()===$code && $code != 'NULL') {

                if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();

                        $usr->setVerify('NULL');
                        $usr->setPassword(
                            $passwordEncoder->encodePassword(
                                $usr,
                                $form->get('plainPassword')->getData()
                            )
                        );
                        $entityManager->flush();


                        return new Response('pakeista');
                }
                return $this->render('reset/resetpassword.html.twig', [
                    'resetForm' => $form->createView(),
                ]);
            }
            else{

                $usr->setVerify('NULL');
                $usr->setPassword(
                    $passwordEncoder->encodePassword(
                        $usr,
                        $form->get('plainPassword')->getData()
                    )
                );
                $entityManager->flush();
                $message = (new \Swift_Message('Nepavykes bandymas pakeisti slaptazodi'))
                    ->setFrom('send@example.com')
                    ->setTo($usr->getEmail())
                    ->setBody(
                        $this->renderView(
                        // templates/emails/registration.html.twig
                            'email/failedattempt.html.twig'
                        ),
                        'text/html'
                    )
                ;
                $mailer->send($message);
            }
        }
        return $this->redirectToRoute('app_login');
    }
}
