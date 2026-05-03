<?php

namespace App\Service;

use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;

class StationJsonImport
{
    public function __construct(private EntityManagerInterface $entityManager){}

    public function importFromGeoJson():void{
        $filePath = __DIR__ . '/../../public/data/stationEssence.geojson';
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        foreach ($data['features'] as $feature) {
            $station = new Station();
            $station->setNom(
                $feature['properties']['name']
                ?? $feature['properties']['brand']
                ?? 'Unnamed Station'
            );
            $station->setLongitude($feature['geometry']['coordinates'][0] ?? 0.0);
            $station->setLatitude($feature['geometry']['coordinates'][1] ?? 0.0);
            $station->setOsmId($feature['id']);
            $this->entityManager->persist($station);

        }
        $this->entityManager->flush();

    }


}
