<?php
// src/Controller/ClientSecurityController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ClientSecurityController extends AbstractController
{
    #[Route('/client/login', name: 'app_client_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response  //fonction pour renvoyer vers la page de connexiondu client
    {
        if ($this->getUser()) {  //vérification si un client n'est pas déjà connecté
             return $this->redirectToRoute('pageclient');
        }

        return $this->render('security/client_login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/client/logout', name: 'app_client_logout')]  //fonction pour la deconnexion 
    public function logout(): void {}
}



