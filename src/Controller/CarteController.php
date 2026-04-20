<?php

namespace App\Controller;

use App\Repository\StockCarburantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CarteController extends AbstractController
{
    #[Route('/carte', name: 'app_carte')]
    public function index(): Response
    {
        return $this->render('carte/index.html.twig', [
            'controller_name' => 'CarteController',
        ]);
    }


    #[Route('/api/carte', name: 'api_carte')]
    public function data(StockCarburantRepository $stockCarburantRepository): Response
    {
        // 1. Récupère les carburants disponibles groupés par nom de station depuis le repository
        //    La méthode findAvailableCarburants() retourne un tableau associatif :
        //    ['Nom Station 1' => ['Carburant A', 'Carburant B'], 'Nom Station 2' => ['Carburant C'], ...]
        $carburantsParStation = $stockCarburantRepository->findAvailableCarburants();

        // 2. Charge le fichier GeoJSON contenant les coordonnées et propriétés des stations
        //    Le chemin du fichier est construit à partir du répertoire racine du projet
        $geojsonPath = $this->getParameter('kernel.project_dir') . '/public/data/stationEssence.geojson';

        // Décode le contenu du fichier en tableau associatif PHP
        $geojson = json_decode(file_get_contents($geojsonPath), true);


        // 3. Parcourt chaque station dans le GeoJSON pour associer les carburants disponibles
        foreach ($geojson['features'] as &$feature) {
            // Récupère le nom de la station depuis les propriétés de la feature GeoJSON
            // L'opérateur ?? null permet de gérer le cas où 'name' n'existe pas
            $stationNom = $feature['properties']['name'] ?? null;

            // Associe les carburants disponibles à la station dans le GeoJSON
            // Si le nom de la station existe dans $carburantsParStation, on utilise les carburants correspondants
            // Sinon, on utilise un tableau vide
            $feature['properties']['carburants'] = $carburantsParStation[$stationNom] ?? [];
        }
        //dd($carburantsParStation);

        // 4. Retourne les données GeoJSON enrichies au format JSON pour le frontend
        //    Le frontend (JavaScript) utilisera ces données pour afficher les stations et leurs carburants sur la carte
        return $this->json($geojson);
    }
}
