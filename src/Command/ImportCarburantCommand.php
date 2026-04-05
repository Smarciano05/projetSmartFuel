<?php

namespace App\Command;

use App\Service\StockCSVImport;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import-stock-csv',
    description: 'Importe les stocks depuis un fichier CSV'
)]
class ImportCarburantCommand extends Command
{
    private StockCSVImport $importService;

    public function __construct(StockCSVImport $importService)
    {
        parent::__construct();
        $this->importService = $importService;
    }

    protected function configure(): void
    {
        // Ici, juste l’argument, pas besoin de setName
        $this->addArgument('file', InputArgument::REQUIRED, 'Chemin vers le fichier CSV');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument('file');
        $messages = $this->importService->importFromCSV($file);

        foreach ($messages as $message) {
            $output->writeln($message);
        }

        return Command::SUCCESS;
    }
}
