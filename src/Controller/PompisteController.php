<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PompisteController extends AbstractController
{
    // chemin pour aller vers la page 'pompiste/index.html.twig' : la base pour tous les pages utilisé par le pompiste 
    #[Route('/pompiste', name: 'app_pompiste')]
    public function index(): Response
    {
        //Récupération de quelque donnnée du pompiste 
        $pompiste = $this->getUser();
        $nom=$pompiste->getNom();
        $prenom=$pompiste->getPrenom();
        $nomStation = $pompiste->getStation()->getNom();

        //Envoie de ces données à la page 'pompiste/index.html.twig': Données du pompiste affiché dans l'en-tete
        return $this->render('pompiste/index.html.twig', [
            'controller_name' => 'PompisteController',
            'NOM'=>$nom,
            'PRENOM'=>$prenom,
            'NOM_station' => $nomStation,

        ]);
    }
}
