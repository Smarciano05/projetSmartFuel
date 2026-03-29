<?php

namespace App\Repository;

use App\Entity\EnregistrementEssence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EnregistrementEssence>
 */
class EnregistrementEssenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnregistrementEssence::class);
    }

    /**
     * Récupère l'historique d'un client par son ID
     */
    public function findByClientId(int $clientId): array
    {
        return $this->createQueryBuilder('e') // 'e' = alias pour EnregistrementEssence
        ->innerJoin('e.station', 's')    // join pour charger la station
        ->addSelect('s')                 // sélectionner la station pour éviter lazy loading
        ->innerJoin('e.immatriculation', 'i') // join pour charger l'immatriculation
        ->addSelect('i')                 // sélectionner l'immatriculation
        ->where('e.client = :clientId')  // filtrer par client
        ->setParameter('clientId', $clientId)
            ->orderBy('e.date', 'DESC')      // ordre par date décroissante
            ->getQuery()
            ->getResult();                   // renvoie un tableau d'entités
    }
}
