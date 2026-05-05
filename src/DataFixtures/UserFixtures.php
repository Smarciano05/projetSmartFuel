<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Pompiste;
use App\Repository\StationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;
    private $stationRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher , StationRepository $stationRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->stationRepository = $stationRepository;
    }

    public function load(ObjectManager $manager): void
    {

        $stationRepository = $this->stationRepository->findOneBy(['nom' => 'Star']);

        // Connexion Pompiste
        $pompiste = new Pompiste();
        $pompiste->setNom("Dupont");
        $pompiste->setPrenom("Marc");
        $pompiste->setEmail("marc.dupont@smartfuel.com");
        $pompiste->setStation($stationRepository);
        $pompiste->setPassword(
            $this->passwordHasher->hashPassword($pompiste, "Smartfuel")
        );
        $pompiste->setNumero(0623242526);
        $pompiste->setIsVerified(true);

        $manager->persist($pompiste);

        // Connexion Client
        $client = new Client();
        $client->setNom("Dubois");
        $client->setPrenom("Sophie");
        $client->setEmail("sophie.dubois@test.com");
        $client->setPassword(
            $this->passwordHasher->hashPassword($client, "Password")
        );
        $client->setNumero(0612131415);

        $manager->persist($client);


        $manager->flush();
    }
}
