<?php

namespace App\Service;

    use App\Entity\Station;
    use App\Entity\StockCarburant;
    use Doctrine\ORM\EntityManagerInterface;

class StockCSVImport
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function importFromCSV(string $file): array
    {
        $messages = [];

        if (!file_exists($file)) {
            $messages[] = "Fichier CSV introuvable : $file";
            return $messages;
        }

        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);

        while (($data = fgetcsv($handle)) !== false) {
            [$typeCarburant, $qteCarburant, $idStation] = $data;
            $station = $this->em->getRepository(Station::class)->find($idStation);
            if (!$station) {
                $messages[] = "Station $idStation introuvable";
                continue;
            }

            $stock = new StockCarburant();
            $stock->setTypeCarburant($typeCarburant);
            $stock->setQteCarburant((float)$qteCarburant);
            $stock->setIdStation($station);
            $this->em->persist($stock);
        }

        fclose($handle);
        $this->em->flush();
        $messages[] = "Import terminé !";

        return $messages;
    }

}
