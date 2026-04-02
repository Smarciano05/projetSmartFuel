<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChoixInscriptionController extends AbstractController
{
    #[Route('/choix/inscription', name: 'app_choix_inscription')]
    public function index(): Response
    {
        return $this->render('choix_inscription/index.html.twig', [
            'controller_name' => 'ChoixInscriptionController',
        ]);
    }
}
