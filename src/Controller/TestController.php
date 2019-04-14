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
    /**
     * @Route("/admin", name="admin_user_list")
     */
    public function index()
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
     * @Route("/admin/{max}", name="create_root")
     */
    public function delete($max, UserPasswordEncoderInterface $passwordEncoder)
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
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
