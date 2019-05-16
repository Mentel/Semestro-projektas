<?php


namespace App\Controller;


use App\Form\ChangePasswordFormType;
use App\Form\CreateCategoryFormType;
use App\Form\UpdateCategoryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\User;

class CategoryController extends AbstractController
{
    /**
     * @Route("/settings/category/createcategory", name="app_createcategory")
     */
    public function CreateCategory(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(CreateCategoryFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $category = new Category();
            $category->setName($data['categoryName']);
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('app_index');
        }

        return $this->render('settings/createcategory.html.twig', [
            'createCategory' => $form->createView(),
        ]);
    }
    /**
     * @Route("/settings/category/updatecategory", name="app_updatecategory")
     */
    public function UpdateCategory(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(UpdateCategoryFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $entityManager = $this->getDoctrine()->getManager();
            $category = $entityManager->getRepository(Category::class)->find($form->get('name')->getData()->getId());
            $newName = $form->get('newName')->getData();
            $category->setName($newName);
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->redirectToRoute('app_updatecategory');
        }

        return $this->render('settings/updatecategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/settings/category/subscribe/{id}", name="app_categorysubscribe")
     */
    public function CategorySubscribe($id, TokenStorageInterface $tokenStorage, \Swift_Mailer $mailer): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $tokenStorage->getToken()->getUser();
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        if ($category != null) {

            $user->addCategory($category);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $message = (new \Swift_Message('Jūs prenumeravote naują kategoriją.'))
                ->setFrom('example@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/subscribedcategory.html.twig',
                        ['categoryName' => $category->getName(), 'userName' => $user->getEmail()]
                    ),
                    'text/html'
                );

            $mailer->send($message);

        }
        return $this->redirectToRoute('app_categorylist');
    }
    /**
     * @Route("/settings/category/unsubscribe/{id}", name="app_categoryunsubscribe")
     */
    public function CategoryUnsubscribe($id, TokenStorageInterface $tokenStorage): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $tokenStorage->getToken()->getUser();
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        if ($category != null) {
            $user->removeCategory($category);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_categorylist');
    }
    /**
     * @Route("/settings/categories", name="app_categorylist")
     */
    public function CategoryList(TokenStorageInterface $tokenStorage): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $tokenStorage->getToken()->getUser();
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        $subscribed = $user->getCategories();
        return $this->render('settings/categories.html.twig', [
            'categories' => $category,
            'subscribed' => $subscribed,
        ]);
    }


}