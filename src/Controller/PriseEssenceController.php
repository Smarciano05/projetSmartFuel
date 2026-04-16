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
        //pour garder les infos du profile:
        $pompiste = $this->getUser();
        //test si c'est bien un obj pompiste
        if (!$pompiste instanceof Pompiste) {
            throw $this->createAccessDeniedException("Vous n'êtes pas un pompiste.");
        }

        $nom=$pompiste->getNom();
        $prenom=$pompiste->getPrenom();
        $nomStation = $pompiste->getStation()->getNom();

        return $this->render('prise_essence/index.html.twig', [
            'enregistrement_essences' => $enregistrementEssenceRepository->findByPompiste($pompiste),
            'NOM'=>$nom,
            'PRENOM'=>$prenom,
            'NOM_station' => $nomStation,

        ]);
    }

    #[Route('/new', name: 'app_prise_essence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pompiste = $this->getUser();

        // Sécurité immédiate : seul un pompiste accède au formulaire
        if (!$pompiste instanceof Pompiste) {
            return new Response('Veuillez vous connecter en tant que pompiste.');
        }

        $enregistrementEssence = new EnregistrementEssence();
        $form = $this->createForm(EnregistrementEssenceType::class, $enregistrementEssence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Liaison Pompiste et Station
            $enregistrementEssence->setPompiste($pompiste);
            $enregistrementEssence->setStation($pompiste->getStation());

            // Gestion de l'Immatriculation
            $numeroSaisi = $form->get('immatriculation')->getData();
            $immatRepo = $entityManager->getRepository(Immatriculation::class);
            $immatriculation = $immatRepo->findOneBy(['numero' => $numeroSaisi]);

            if (!$immatriculation) {
                $immatriculation = new Immatriculation();
                $immatriculation->setNumero($numeroSaisi);
                $entityManager->persist($immatriculation);
            }
            $enregistrementEssence->setImmatriculation($immatriculation);

            // Gestion du Client (Le point bloquant)
            $emailSaisi = $form->get('client_email')->getData();
            $client = $entityManager->getRepository(Client::class)->findOneBy(['email' => $emailSaisi]);

            if (!$client) {
                $this->addFlash('error', "Client introuvable avec l'email : " . $emailSaisi);
                return $this->redirectToRoute('app_prise_essence_index');
            }

            // ON ATTACHE LE CLIENT ICI
            $enregistrementEssence->setClient($client);

            // Autres données
            $enregistrementEssence->setDate(new \DateTime());
            $enregistrementEssence->setTypeCarburant($form->get('typeCarburant')->getData());
            $enregistrementEssence->setQuantite($form->get('quantite')->getData());


            // Sauvegarde finale
            $entityManager->persist($enregistrementEssence);
            $entityManager->flush();

            // On crée le message flash (nommé 'success')
            $this->addFlash('success', 'La prise d\'essence pour ' . $client->getNom() . ' a été enregistrée avec succès !');
            return $this->redirectToRoute('app_prise_essence_index');
        }

        //pour garder les infos du profile:

        $nom=$pompiste->getNom();
        $prenom=$pompiste->getPrenom();
        $nomStation = $pompiste->getStation()->getNom();

        return $this->render('prise_essence/new.html.twig', [
            'form' => $form->createView(),
            'station' => $nomStation,
            'NOM'=>$nom,
            'PRENOM'=>$prenom,
            'NOM_station' => $nomStation,
        ]);
    }

    #[Route('/{id}', name: 'app_prise_essence_show', methods: ['GET'])]
    public function show(EnregistrementEssence $enregistrementEssence): Response
    {
        //pour garder les infos du profile:
        $pompiste = $this->getUser();
        $nom=$pompiste->getNom();
        $prenom=$pompiste->getPrenom();
        $nomStation = $pompiste->getStation()->getNom();

        return $this->render('prise_essence/show.html.twig', [
            'enregistrement_essence' => $enregistrementEssence,
            'NOM'=>$nom,
            'PRENOM'=>$prenom,
            'NOM_station' => $nomStation,
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

        //pour garder les infos du profile:
        $pompiste = $this->getUser();
        $nom=$pompiste->getNom();
        $prenom=$pompiste->getPrenom();
        $nomStation = $pompiste->getStation()->getNom();

        return $this->render('prise_essence/edit.html.twig', [
            'enregistrement_essence' => $enregistrementEssence,
            'form' => $form,
            'NOM'=>$nom,
            'PRENOM'=>$prenom,
            'NOM_station' => $nomStation,
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
