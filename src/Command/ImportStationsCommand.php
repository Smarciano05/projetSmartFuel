<?php

namespace App\Command;

use App\Service\StationJsonImport;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-stations',
    description: 'Importe les stations depuis le fichier GeoJSON dans la base de données'
)]
class ImportStationsCommand extends Command
{
    private StationJsonImport $stationJsonImport;

    public function __construct(StationJsonImport $stationJsonImport)
    {
        parent::__construct();
        $this->stationJsonImport = $stationJsonImport;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Début de l’import des stations...');

        $this->stationJsonImport->importFromGeoJson();

        $output->writeln('Import terminé avec succès !');

        return Command::SUCCESS;
    }
}
