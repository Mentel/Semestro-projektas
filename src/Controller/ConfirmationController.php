<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\Security\Core\Security;
use App\Form\EventAddFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ConfirmationController extends AbstractController
{
    /**
     * @Route("/user/confirm/{id}/{code}", name="confirm")
     */
    public function Confirm($id, $code)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $usr = $entityManager->getRepository(User::class)
            ->find($id);
        if ($code === $usr->getVerify()) {
            $usr->setRoles(['ROLE_USER']);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_login');
    }
}
