<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    //CHEMIN vers la page d'Accueil
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    // CHEMIN vers la page "à propos"
    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response  
    {
        return $this->render('about/index.html.twig');
    }
    // CHEMIN vers la page "copy right"
    #[Route('/copy_right', name: 'app_right')]
    public function copyRight(): Response  
    {
        return $this->render('copyright.html.twig');
    }
}
