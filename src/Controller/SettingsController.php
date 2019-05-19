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
    /**
     * @Route("/settings/admin", name="app_adminsettings")
     */
    public function adminSettings()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('settings/adminsettings.html.twig');
    }
}