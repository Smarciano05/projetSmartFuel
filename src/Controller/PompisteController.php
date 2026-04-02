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
        $pompiste = $this->getUser();

        $nom=$pompiste->getNom();
        $prenom=$pompiste->getPrenom();
        $nomStation = $pompiste->getStation()->getNom();
        return $this->render('pompiste/index.html.twig', [
            'controller_name' => 'PompisteController',
            'NOM'=>$nom,
            'PRENOM'=>$prenom,
            'NOM_station' => $nomStation,

        ]);
    }
}
