<?php

namespace App\Controller;

use App\Entity\Pompiste;
use App\Repository\StockCarburantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StockCarburantController extends AbstractController
{
    #[Route('/stock/carburant', name: 'app_stock_carburant')]
    public function index(StockCarburantRepository $repository): Response
    {
        // Récupérer le pompiste connecté (exemple avec Symfony Security)
        $pompiste = $this->getUser();
        dd($pompiste);
        // 1. On vérifie si l'utilisateur est bien une instance de Pompiste
        if (!$pompiste instanceof Pompiste) {
            // Si c'est un Client (ou pas connecté), on redirige ou on affiche une erreur
            $this->addFlash('danger', "Accès réservé aux pompistes.");
            return $this->redirectToRoute('app_home');
        }
        
        // Récupérer l'id de la station du pompiste
        $idStation = $pompiste->getStations()->getId();
        
        // Filtrer les stocks par idStation
        $listStockCarbStation = $repository->findBy(['idStation' => $idStation]);

        return $this->render('stock_carburant/index.html.twig', [
            'controller_name' => 'StockCarburantController',
            'listStockCarbStation' => $listStockCarbStation,
        ]);
    }


    
}
