<?php

namespace App\Controller;

use App\Entity\Pompiste;
use App\Entity\Station;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /*Cette route a 2 utilité : 
    1er utilitée (*) :  lorsque qu'on appuie sur n'importe qu'elle boutton qui se dirige vers l'inscription du pompiste, on a l'affichage du formulaire vide
    2e utilitée ($) : lorsque qu'on appuie sur le bouton en bas du formulaire d'inscription pompiste après avoir bien mis nos information dans les input, les données du pompiste sont enregistré dans la bdd
    */
    #[Route('/register', name: 'inscription_pompiste')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        //(*) création d'un nouveau pompiste vide pour ajouter les infos après avoir envoyer le formualire et que les données sont correctes
        $user = new Pompiste();

        //(*) création du formulaire pour pouvoir ajouter les données du client pour la 2e utilité
        $form = $this->createForm(RegistrationFormType::class, $user);

        //($) Le formulaire récupère les données POST 
        $form->handleRequest($request);

        //($) Verfication : le formuaile a bien été envoyé par le pompiste? et est ce que les données sont correctes?
        if ($form->isSubmitted() && $form->isValid()) {

            // modifie l'id station vide par l'id station extrait du nom de la station que le pompiste a donné
            $station = $form->get('station')->getData();
            $user->setStation($station);
            
            // modifie le mot de passe vide par le mot de passe hasé (=plus sécurisé) donné par le pompiste
            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData();));
            
            // Le pompiste est user donc on met par defaut ROLE_USER
            $user->setRoles(['ROLE_USER']);

            //Doctrine "surveille" l'objet $client (prépare l'insertion sans l'exécuter):  C'est comme un commit des données 
            $entityManager->persist($user);

            //Exécute TOUTES les opérations préparées (INSERT dans la base): c'est comme un push des données vers la base de données 
            $entityManager->flush();

            // Redirection vers la page de connexion après etre inscrit 
            return $this->redirectToRoute('app_login');
        }

        // ce return vers la page d'inscription est exécuté si: 
        //(*) si on est dans le 1er cas 
        //ou ($) si on est dans le 2e cas et que les données insérées ne sont PAS correctes
        return $this->render('registration/register.html.twig', [
            //affichage d'un formulaire vide dans la page "registration/client_register.html.twig"
            'registrationForm' => $form->createView(),
        ]);
    }

}
