<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Immatriculation;
use App\Entity\Pompiste;
use App\Entity\Station;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $station = $manager->getRepository(Station::class)->findOneBy(['nom' => "Star"]);
        $station1 = $manager->getRepository(Station::class)->findOneBy(['nom' => "TOTAL"]);


        //creer client 1
        $client1 = new Client();
        $client1->setNom('Dupont');
        $client1->setPrenom('Jean');
        $manager->persist($client1);

        //creer client 2
        $client2 = new Client();
        $client2->setNom('Durand');
        $client2->setPrenom('Marie');
        $manager->persist($client2);

        //creer pompiste 1
        $pompiste1 = new Pompiste();
        $pompiste1->setNom('Martin');
        $pompiste1->setPrenom('Pierre');
        $pompiste1->setStation($station);
        $manager->persist($pompiste1);

        //creer pompiste 2
        $pompiste2 = new Pompiste();
        $pompiste2->setNom('Lefevre');
        $pompiste2->setPrenom('Sophie');
        $pompiste2->setStation($station1);
        $manager->persist($pompiste2);

        // creer immatriculations pour les clients
        $immatriculation1 = new Immatriculation();
        $immatriculation1->setNumero('AB-123-CD');
        $manager->persist($immatriculation1);

        //creer immatriculation pour le client 2
        $immatriculation2 = new Immatriculation();
        $immatriculation2->setNumero('EF-456-GH');
        $manager->persist($immatriculation2);

        //creer immatriculation pour le client 1
        $immatriculation3 = new Immatriculation();
        $immatriculation3->setNumero('IJ-789-KL');
        $manager->persist($immatriculation3);



        $manager->flush();
    }
}
