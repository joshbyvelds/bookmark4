<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SettingsRepository;


class DashboardController extends AbstractController
{
    #[Route('/main', name: 'dashboard')]
    public function index(SettingsRepository $settingsRepo): Response
    {
        $user = $this->getUser();
        $settings = $settingsRepo->findOneBy(['user' => $user->getId()]);
        $bookmarks = $user->getBookmarks();

        return $this->render('dashboard/index.html.twig', [
            'settings' => $settings,
            'bookmarks' => $bookmarks,
        ]);
    }
}
