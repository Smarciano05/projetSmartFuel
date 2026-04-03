<?php

namespace App\Controller;

use App\Repository\EnregistrementEssenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecherchePlaqueController extends AbstractController
{
    #[Route('/recherche/plaque', name: 'app_recherche_plaque')]
    public function index(Request $request, EnregistrementEssenceRepository $repo): Response
    {
        $plaque = $request->query->get('q'); // Récupère la recherche ?q=AA-123-AA
        $resultats = [];
        $peutRavitallier = true;

        if ($plaque) {
            // On cherche les enregistrements liés à l'immatriculation, triés par date décroissante
            $resultats = $repo->createQueryBuilder('e')
                ->join('e.immatriculation', 'i')
                ->where('i.numero = :numero')
                ->setParameter('numero', $plaque)
                ->orderBy('e.date', 'DESC')
                ->getQuery()
                ->getResult();

            // Vérification des 24h sur le dernier enregistrement
            if (!empty($resultats)) {
                $dernierePrise = $resultats[0]->getDate();
                $maintenant = new \DateTime();
                $intervalle = $maintenant->diff($dernierePrise);
                
                // Si la différence est de moins de 24h (1 jour)
                if ($intervalle->days < 1 && $dernierePrise > $maintenant->modify('-24 hours')) {
                    $peutRavitallier = false;
                }
            }
        }

        //pour garder les infos du profile: 
        $pompiste = $this->getUser();
        $nom=$pompiste->getNom();
        $prenom=$pompiste->getPrenom();
        $nomStation = $pompiste->getStation()->getNom();

        return $this->render('recherche_plaque/index.html.twig', [
            'resultats' => $resultats,
            'plaque_recherchee' => $plaque,
            'peut_ravitailler' => $peutRavitallier,
            'NOM'=>$nom,
            'PRENOM'=>$prenom,
            'NOM_station' => $nomStation,
        ]);
    }
}