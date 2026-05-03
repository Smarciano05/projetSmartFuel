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
        // Récupère les carburants disponibles groupés par  id(osm) de station depuis le repository
        $carburantsParStation = $stockCarburantRepository->findAvailableCarburants();

        // Charge le fichier GeoJSON
        $geojsonPath = $this->getParameter('kernel.project_dir') . '/public/data/stationEssence.geojson';

        $geojson = json_decode(file_get_contents($geojsonPath), true);

        // Parcourt chaque station dans le GeoJSON pour associer les carburants disponibles
        foreach ($geojson['features'] as &$feature) {

            $osmId = $feature['id'];

            $feature['properties']['carburants'] =
                $carburantsParStation[$osmId] ?? [];
        }
        //dd($carburantsParStation);

        return $this->json($geojson);
    }
}
