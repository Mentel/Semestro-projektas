<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/list", name="app_user_list")
     */
    public function listUsers()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render(
            'user/list.html.twig', [
                'users' => $users
            ]
        );
    }

    /**
     * @Route("/user/delete/{id}", name="app_user_delete")
     */
    public function deleteUser($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)
            ->find($id);
        if ($user != null){
            $entityManager->remove($user);
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_user_list');
    }
}
