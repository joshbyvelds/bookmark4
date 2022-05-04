<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SplashController extends AbstractController
{
    #[Route('/', name: 'splash')]
    public function index(): Response
    {
        return $this->render('splash/index.html.twig', [
            'controller_name' => 'SplashController',
        ]);
    }
}
