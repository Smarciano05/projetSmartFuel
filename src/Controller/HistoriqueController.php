<?php

namespace App\Controller;

use App\Repository\EnregistrementEssenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HistoriqueController extends AbstractController
{
    #[Route('/historique', name: 'app_historique')]
    public function index(EnregistrementEssenceRepository $enregistrementEssenceRepository): Response
    {

        //si le client est connecté
        $clientId = 9;
        // recuperer les enregistrement effectué
        $historique = $enregistrementEssenceRepository->findByClientId($clientId);


        return $this->render('historique/index.html.twig', [
            'historique' => $historique,
        ]);
    }
}
