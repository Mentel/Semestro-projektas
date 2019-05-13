<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangePasswordController extends AbstractController
{
    //TODO: Check how this works(where does the user name gets set)
    /**
     * @Route("/changepassword", name="app_changepassword")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        $error = "test";
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

        }

        return $this->render('security/changepassword.html.twig', [
            'changepasswordForm' => $form->createView(),
            'error' => $error,
        ]);
    }
}
