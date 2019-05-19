<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function renderIndex(Security $security) :Response
    {
        $user=$security->getUser();
        if($user != null) {
            if ($user->getRoles() === ['ROLE_VERIFIEDNT']) {
                return $this->render('registration/confirm.html.twig', [
                    'email' => $user->getUsername()
                ]);
            }
        }
        return $this->render('index.html.twig');
    }
}