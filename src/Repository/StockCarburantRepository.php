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

    // je recupere a partir de osmId qui est l'id dans geoJson et qui est unique
    //pck sinon l'id est auto-incremente et a chaque il changé par rapp au fichier csv
    //et qui va permettre de faire le lien avec stock carburant
    public function findAvailableCarburants(): array
    {
        $rawData = $this->createQueryBuilder('sc')
            ->select('st.osmId AS osmId', 'sc.typeCarburant')
            ->join('sc.idStation', 'st')
            ->where('sc.qteCarburant > 0')
            ->getQuery()
            ->getResult();

        //regrouper
        $result = [];
        foreach ($rawData as $row) {
            $osmId = $row['osmId'];
            if (!isset($result[$osmId])) {
                $result[$osmId] = [];
            }
            $result[$osmId][] = $row['typeCarburant'];
        }
        return $result;
    }
}
