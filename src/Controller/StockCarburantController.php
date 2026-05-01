<?php

namespace App\Controller;

use App\Entity\Pompiste;
use App\Entity\StockCarburant;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\StockCarburantRepository;+
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StockCarburantController extends AbstractController
{
    // chemin pour aller à la page de stock carburant
    #[Route('/stock/carburant', name: 'app_stock_carburant')]
    public function index(StockCarburantRepository $repository): Response
    {
        // Récupérer le pompiste connecté (exemple avec Symfony Security)
        $pompiste = $this->getUser();
        // On vérifie si l'utilisateur est bien une instance de Pompiste
        if (!$pompiste instanceof Pompiste) {
            // Si c'est un Client (ou pas connecté), on redirige ou on affiche une erreur
            $this->addFlash('danger', "Accès réservé aux pompistes.");
            return $this->redirectToRoute('app_home');
        }

        //pour garder les infos du profile
        $nom=$pompiste->getNom();
        $prenom=$pompiste->getPrenom();
        $nomStation = $pompiste->getStation()->getNom();
        
        // Récupérer l'id de la station du pompiste
        $idStation = $pompiste->getStation()->getId();
        
        // Filtrer les stocks par idStation
        $listStockCarbStation = $repository->findBy(['idStation' => $idStation]);

        return $this->render('stock_carburant/index.html.twig', [
            'controller_name' => 'StockCarburantController',
            'listStockCarbStation' => $listStockCarbStation,
            'NOM'=>$nom,
            'PRENOM'=>$prenom,
            'NOM_station' => $nomStation,
        ]);
    }


    //Cette route est appelée quand le pompiste clique sur "Ajouter" dans la page des stocks
    // {id} du stock carburant
    #[Route('/stock/ajouter/{id}', name: 'app_stock_ajouter', methods: ['POST'])]
    public function ajouterStock(StockCarburant $stock,Request $request,EntityManagerInterface $entityManager): Response {

        // Récupérer la quantité que le pompiste a écrit dans l'input " <input type="number" name="quantite" style="width: 80px;">"
        $qteAAjouter = $request->request->get('quantite');
        

        // Vérification de sécurité
        // On refuse les quantités négatives ou nulles
        if ($qteAAjouter <= 0) {
            $this->addFlash('error', 'La quantité doit être supérieure à 0');
            return $this->redirectToRoute('app_stock_carburant');
        }


        // Mise à jour du stock
        // ajouterQteCarburant() = méthode qui ajoute des litres au stock existant qui se trouve dans entity de StockCarburant
        $stock->ajouterQteCarburant($qteAAjouter);


        // Sauvegarde dans la base de données les changements
        $entityManager->flush();


        // Message de confirmation
        $this->addFlash('success', $qteAAjouter . 'L ajoutés au stock de ' . $stock->getTypeCarburant());

        // REDIRECTION
        // Retourne à la page des stocks pour voir le nouveau nombre
        return $this->redirectToRoute('app_stock_carburant');
    }


    
}
