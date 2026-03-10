<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\EnregistrementEssence;
use App\Entity\Immatriculation;
use App\Entity\Pompiste;
use App\Form\EnregistrerEssenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\App;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\DataFixtures\AppFixtures;

final class EnregistrerEssenceController extends AbstractController
{
    #[Route('/enregistrer/essence/create', name: 'app_enregistrer_essence')]
    public function create(Request $request , EntityManagerInterface $entityManager): Response
    {

        // creer une instance de l'entité EnregistrementEssence
        $enregistrementEssence = new EnregistrementEssence();

        //creer le formulaire à partir de l'entité EnregistrementEssence
        $form = $this->createForm(EnregistrerEssenceType::class, $enregistrementEssence);
        //traite le formulaire
        $form->handleRequest($request);

        //verifier si soumis et valide -> que le pompiste a cliqué sur le bouton et regle valide
        if($form->isSubmitted() && $form->isValid()) {

            //on lie le pompiste connecté
            $pompiste = $entityManager->getRepository(Pompiste::class)->findOneBy(['nom' => "Martin"]);
            $enregistrementEssence->setPompiste($pompiste);

            $enregistrementEssence->setStation($pompiste->getStation());

            //on lie l'immatriculation du client ?
            $numero = $form->get('immatriculation')->getData();
            $immatriculation = $entityManager->getRepository(Immatriculation::class)->findOneBy(['numero' => $numero]);
            $enregistrementEssence->setImmatriculation($immatriculation);
            $enregistrementEssence->setClient($immatriculation->getClient());

            // Recuperer les données du formulaire
            $enregistrementEssence->setDate(new \DateTime());
            $enregistrementEssence->setTypeCarburant($form->get('typeCarburant')->getData());
            $enregistrementEssence->setQuantite($form->get('quantite')->getData());

            //sauvegarde dans la base de données
            $entityManager->persist($enregistrementEssence);
            $entityManager->flush();

            return new Response('Enregistrement de l\'essence réussi !');
        }

        return $this->render('enregistrer_essence/index.html.twig', [
            'controller_name' => 'EnregistrerEssenceController',
                'form' => $form->createView(),

        ]);
    }




}
