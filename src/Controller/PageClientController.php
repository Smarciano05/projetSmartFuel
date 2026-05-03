<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EnregistrementEssenceRepository; //need this pour la recherche 
use Symfony\Component\Security\Http\Attribute\IsGranted;   

final class PageClientController extends AbstractController
{
    #[Route('/client', name: 'pageclient')]
    public function index(EnregistrementEssenceRepository $repository): Response
    {
    
    //On récupère l'utilisateur connecté
    $user = $this->getUser();

  

    //récupère les données en base
    $historique = $repository->findbyClientSorted($user);
        return $this->render('home/pageclient.html.twig', [
            'user'=> $user,
            'historique' => $historique,
            'controller_name' => 'PageClientController',
        ]);
    }


}
