<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TestController extends AbstractController
{
    //TODO: Remove in production
    /**
     * @Route("/admin", name="app_create_superuser")
     */
    public function createAdminAccount(UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        // encode the plain password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                "420"
            )
        );
        $user->setCreatedAt();
        $user->setRoles(['ROLE_USER', 'ROLE_SUPERUSER', 'ROLE_ADMIN']);
        $user->setEmail("root@root");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
        echo 'nice';
        return new Response('nic');
    }
}
