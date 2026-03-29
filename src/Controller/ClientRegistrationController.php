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
    #[Route('/client/register', name: 'inscription_client')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $client = new Client();
        $form = $this->createForm(ClientRegistrationFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash du mot de passe
            $client->setPassword(
                $userPasswordHasher->hashPassword(
                    $client,
                    $form->get('plainPassword')->getData()
                )
            );
            
            // Rôle par défaut
            $client->setRoles(['ROLE_USER']);

            $entityManager->persist($client);
            $entityManager->flush();

            // Message de succès
            $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
            
            // Redirection vers la page de connexion
            return $this->redirectToRoute('app_client');
        }

        return $this->render('client_registration/index.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
