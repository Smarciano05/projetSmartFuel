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

    //    /**
    //     * @return EnregistrementEssence[] Returns an array of EnregistrementEssence objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EnregistrementEssence
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Récupère l'historique des enregistrements pour un client
     * @param int $clientId
     * @return EnregistrementEssence[]
     */
    public function findByClient($client): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.client = :client')
            ->setParameter('client', $client)
            ->orderBy('e.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
}

