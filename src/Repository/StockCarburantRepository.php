<?php

namespace App\Repository;

use App\Entity\StockCarburant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockCarburant>
 */
class StockCarburantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockCarburant::class);
    }


//    /**
//     * @return StockCarburant[] Returns an array of StockCarburant objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StockCarburant
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findAvailableCarburants(): array
    {
        // 1. Récupère les données brutes depuis la base de données
        //    On sélectionne le nom de la station et le type de carburant pour les stocks où la quantité est supérieure à 0
        $rawData = $this->createQueryBuilder('sc') // 'sc' est l'alias pour StockCarburant
        ->select('st.nom AS stationNom', 'sc.typeCarburant') // Sélectionne le nom de la station et le type de carburant
        ->join('sc.idStation', 'st') // Jointure avec l'entité Station (alias 'st') via la relation idStation
        ->where('sc.qteCarburant > 0') // Filtre pour ne garder que les stocks avec une quantité positive
        ->getQuery() // Construit la requête SQL
        ->getResult(); // Exécute la requête et retourne les résultats

        // 2. Regroupe les carburants par nom de station
        //    On construit un tableau associatif où chaque clé est un nom de station
        //    et chaque valeur est un tableau des types de carburants disponibles pour cette station
        $result = [];
        foreach ($rawData as $row) {
            $stationNom = $row['stationNom']; // Récupère le nom de la station
            if (!isset($result[$stationNom])) {
                // Si la station n'existe pas encore dans le tableau, on l'initialise
                $result[$stationNom] = [];
            }
            // Ajoute le type de carburant au tableau de la station
            $result[$stationNom][] = $row['typeCarburant'];
        }

        // Retourne le tableau associatif final
        return $result;
    }
}
