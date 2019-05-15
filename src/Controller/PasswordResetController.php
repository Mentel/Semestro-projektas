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
        $entityManager = $this->getDoctrine()->getManager();
        $usr = $entityManager->getRepository(User::class)
            ->findEmail();
        if ($usr!=null){
            if ($usr->getVerify() != 'NULL') {
                if ($code === $usr->getVerify()) {
                    $usr->setRoles(['ROLE_USER']);
                    $usr->setVerify('NULL');
                    $entityManager->flush();
                }
            }
        }
    }
}
