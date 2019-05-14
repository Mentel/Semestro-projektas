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


class ConfirmationController extends AbstractController
{
    /**
     * @Route("/user/confirm/{i}", name="confirm")
     */
    public function Confirm($i)
    {
        $user = $this->getUser();
        if($i === $user->getVerification())
        return new Response('nic');
    }
}
