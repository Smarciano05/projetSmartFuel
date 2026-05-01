<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ClientRegistrationController extends AbstractController
{
    /*Cette route a 2 cas d'utilisation : 
    1er cas (*) :  lorsque qu'on appuie sur n'importe qu'elle boutton qui se dirige vers l'inscription du client, on a l'affichage du formulaire vide
    2e cas ($) : lorsque qu'on appuie sur le bouton en bas du formulaire d'inscription client après avoir bien mis nos information dans les input, les données du client sont enregistré dans la bdd
    */
    #[Route('/client/register', name: 'inscription_client')]
    public function register(Request $request,UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager): Response {
        //(*) création d'un nouveau client vide pour ajouter les infos après avoir envoyer le formualire et que les données sont correctes
        $client = new Client();

        //(*) création du formulaire pour pouvoir ajouter les données du client pour la 2e utilité
        $form = $this->createForm(ClientRegistrationFormType::class, $client);

        //($) Le formulaire récupère les données POST 
        $form->handleRequest($request);


        //($) Verfication : le formuaile a bien été envoyé par le client? et est ce que les données sont correctes?
        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $client->setPassword(
                $userPasswordHasher->hashPassword(
                    $client,
                    $form->get('plainPassword')->getData()
                )
            );
            
            // Le client est user donc on met par defaut ROLE_USER
            $client->setRoles(['ROLE_USER']);

            //Doctrine "surveille" l'objet $client (prépare l'insertion sans l'exécuter):  C'est comme un commit des données 
            $entityManager->persist($client);

            //Exécute TOUTES les opérations préparées (INSERT dans la base): c'est comme un push des données vers la base de données 
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
            
            // Redirection vers la page de connexion après etre inscrit 
            return $this->redirectToRoute('app_client_login');
        }

        // ce return vers la page d'inscription est exécuté si: 
        //(*) si on est dans le 1er cas 
        //ou ($) si on est dans le 2e cas et que les données insérées ne sont PAS correctes
        return $this->render('registration/client_register.html.twig', [
            //affichage d'un formulaire vide dans la page "registration/client_register.html.twig"
            'registrationForm' => $form->createView(),
        ]);
    }

}

    
