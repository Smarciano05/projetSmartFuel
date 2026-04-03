<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EnregistrementEssenceRepository; //need this pour la recherche 
use Symfony\Component\Security\Http\Attribute\IsGranted;  //don't know yet 

final class PageClientController extends AbstractController
{
    #[Route('/client', name: 'pageclient')]
    public function index(EnregistrementEssenceRepository $repository): Response
    {
    
    // 1. Sécurité : On récupère l'utilisateur connecté
    $user = $this->getUser();

    // 2. Si l'utilisateur n'est pas connecté, on peut choisir de le rediriger
   
    //if (!$user) {
   //     return $this->redirectToRoute('app_login');
    //}

    //récupère les données en base
    $historique = $repository->findbyClientSorted($user);
        return $this->render('home/pageclient.html.twig', [
            'user'=> $user,
            'historique' => $historique,
            'controller_name' => 'PageClientController',
        ]);
    }


}
