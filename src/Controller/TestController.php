<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TestController extends AbstractController
{
    //TODO: redo functions
    /**
     * @Route("/user/list", name="app_user_list")
     */
    public function listUsers()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $repository = $this->getDoctrine()->getRepository(User::class)
            ->findAll();
        foreach($repository as &$a)
        {
            $a->getEmail();
            echo "<br>";
            echo $a->getEmail();
            foreach($a->getRoles() as &$b){
                echo "<br>";
                echo "role";
                echo $b;
            }
        }
        echo "<br>";
        return new Response('nic');
    }

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

    //TODO: Check if this actually works
    /**
     * @Route("/user/delete/{max}", name="app_user_delete")
     */
    public function deleteUser($max)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Event::class)
            ->findAll();
        foreach($repository as &$a)
        {
            $entityManager->remove($a);
        }
        $repository = $this->getDoctrine()->getRepository(User::class)
            ->findAll();
        foreach($repository as &$a)
        {
            $entityManager->remove($a);
        }
        $entityManager->flush();
        return new Response('gz');
    }
}
