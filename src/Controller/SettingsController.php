<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SettingsController extends AbstractController
{
    /**
     * @Route("/settings", name="app_settings")
     */
    public function settings()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('settings/settings.html.twig');
    }
}