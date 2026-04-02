<?php

namespace App\Controller;

use App\Entity\EnregistrementEssence;
use App\Entity\Immatriculation;
use App\Entity\Pompiste;
use App\Entity\Client;
use App\Form\EnregistrementEssenceType;
use App\Repository\EnregistrementEssenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/prise/essence')]
final class PriseEssenceController extends AbstractController
{
    #[Route(name: 'app_prise_essence_index', methods: ['GET'])]
    public function index(EnregistrementEssenceRepository $enregistrementEssenceRepository): Response
    {
        return $this->render('prise_essence/index.html.twig', [
            'enregistrement_essences' => $enregistrementEssenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_prise_essence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // creer une instance de l'entité EnregistrementEssence
        $enregistrementEssence = new EnregistrementEssence();

        //creer le formulaire à partir de l'entité EnregistrementEssence
        $form = $this->createForm(EnregistrementEssenceType::class, $enregistrementEssence);
        //traite le formulaire
        $form->handleRequest($request);

        //afficher le nom de la station


        //recuperer le pompiste connecté pour avoir le nom de la station lié à ce pompiste
        if ($this->getUser() instanceof Pompiste) {



            $pompiste = $this->getUser();


            $station = $pompiste->getStation();
            $nomStation = $station->getNom();
        }

        //verifier si soumis et valide -> que le pompiste a cliqué sur le bouton et regle valide
        if ($form->isSubmitted() && $form->isValid()) {

            //on lie le pompiste connecté
            if ($this->getUser() instanceof Pompiste) {
                $pompiste = $this->getUser();

                //
                $enregistrementEssence->setPompiste($pompiste);

                //pour le nom de la station
                $enregistrementEssence->setStation($pompiste->getStation());

                // Recuperer les données du formulaire  -modif mariam parce que immatriculation c'est un obj maintenant pas juste un str 
                // récupérer le texte saisi 
                $numeroSaisi = $form->get('immatriculation')->getData();

                // chercher si cette immatriculation existe déjà en base
                $immatRepo = $entityManager->getRepository(Immatriculation::class);
                $immatriculation = $immatRepo->findOneBy(['numero' => $numeroSaisi]);

                // si elle n'existe pas on crée 
                if (!$immatriculation) {
                    $immatriculation = new Immatriculation();
                    $immatriculation->setNumero($numeroSaisi);
                    // On demande à Doctrine de se préparer à créer cette nouvelle immatriculation
                    $entityManager->persist($immatriculation);
                }

                // on lie l'objet Immatriculation  à l'enregistrement
                $enregistrementEssence->setImmatriculation($immatriculation);



                $enregistrementEssence->setDate(new \DateTime());
                $enregistrementEssence->setTypeCarburant($form->get('typeCarburant')->getData());
                $enregistrementEssence->setQuantite($form->get('quantite')->getData());


                //récupérer le champs de email client , trouver le client qui correspond et le mettre

                //récupérer l'email saisi
                $emailSaisi = $form->get('client_email')->getData();

                // chercher le client correspondant
                $clientRepo = $entityManager->getRepository(Client::class);
                $client = $clientRepo->findOneBy(['email' => $emailSaisi]);

                //Vérifier si le client existe
                if (!$client) {

                    return new Response("Erreur : Aucun client trouvé avec l'adresse " . $emailSaisi);
                }

                // lier le client à l'enregistrement
                $enregistrementEssence->setClient($client);

                //sauvegarde dans la base de données
                $entityManager->persist($enregistrementEssence);
                $entityManager->flush();



                return new Response('Enregistrement de l\'essence réussi !');
            } else {
                return new Response(' Connectez-vous en tant que pompiste');
            }
        }

        return $this->render('prise_essence/new.html.twig', [
            'controller_name' => 'EnregistrerEssenceController',
            'form' => $form->createView(),
            'station' => $nomStation,

        ]);
    }

    #[Route('/{id}', name: 'app_prise_essence_show', methods: ['GET'])]
    public function show(EnregistrementEssence $enregistrementEssence): Response
    {
        return $this->render('prise_essence/show.html.twig', [
            'enregistrement_essence' => $enregistrementEssence,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prise_essence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EnregistrementEssence $enregistrementEssence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnregistrementEssenceType::class, $enregistrementEssence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_prise_essence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prise_essence/edit.html.twig', [
            'enregistrement_essence' => $enregistrementEssence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prise_essence_delete', methods: ['POST'])]
    public function delete(Request $request, EnregistrementEssence $enregistrementEssence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $enregistrementEssence->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($enregistrementEssence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prise_essence_index', [], Response::HTTP_SEE_OTHER);
    }
}
