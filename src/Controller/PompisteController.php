<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PompisteController extends AbstractController
{
    #[Route('/pompiste', name: 'app_pompiste')]
    public function index(): Response
    {
        return $this->render('pompiste/index.html.twig', [
            'controller_name' => 'PompisteController',
        ]);
    }
}
