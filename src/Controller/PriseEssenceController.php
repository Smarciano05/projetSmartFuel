<?php

namespace App\Controller;

use App\Entity\EnregistrementEssence;
use App\Entity\Immatriculation;
use App\Entity\Pompiste;
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
        // if($this->getUser()) {}
        $pompiste = $entityManager->getRepository(Pompiste::class)->findOneBy(['nom' => "Martin"]);
        $station = $pompiste->getStation();

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
            $enregistrementEssence->setDate(new \DateTimeImmutable());
            $enregistrementEssence->setTypeCarburant($form->get('typeCarburant')->getData());
            $enregistrementEssence->setQuantite($form->get('quantite')->getData());

            //sauvegarde dans la base de données
            $entityManager->persist($enregistrementEssence);
            $entityManager->flush();

            return new Response('Enregistrement de l\'essence réussi !');
        }

        return $this->render('prise_essence/new.html.twig', [
            'controller_name' => 'EnregistrerEssenceController',
            'form' => $form->createView(),
            'station' => $station ,

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
        if ($this->isCsrfTokenValid('delete'.$enregistrementEssence->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($enregistrementEssence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prise_essence_index', [], Response::HTTP_SEE_OTHER);
    }
}
