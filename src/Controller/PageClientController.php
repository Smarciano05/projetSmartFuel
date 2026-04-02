<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PageClientController extends AbstractController
{
    #[Route('/client', name: 'pageclient')]
    public function index(): Response
    {
        return $this->render('home/pageclient.html.twig', [
            'controller_name' => 'PageClientController',
        ]);
    }
}
