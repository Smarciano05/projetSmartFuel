<?php

namespace App\Repository;

use App\Entity\EnregistrementEssence;
use App\Entity\Client;
use App\Entity\Immatriculation;
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
 public function findByClientSorted(Client $user): array{
    return $this->createQueryBuilder('e')
        ->andWhere('e.client = :val')
        ->setParameter('val', $user)
        ->orderBy('e.date', 'DESC')
        ->getQuery()
        ->getResult();
}

       public function findOneByIdPompiste($value): ?EnregistrementEssence
      {
           return $this->createQueryBuilder('e')
               ->andWhere('e.exampleField = :val')
              ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
          ;
       }
}
