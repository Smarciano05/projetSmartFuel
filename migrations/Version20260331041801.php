<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260331041801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock_carburant (id INT AUTO_INCREMENT NOT NULL, type_carburant VARCHAR(255) NOT NULL, qte_carburant DOUBLE PRECISION NOT NULL, id_station_id INT NOT NULL, INDEX IDX_2CF7D5E2843732E2 (id_station_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE stock_carburant ADD CONSTRAINT FK_2CF7D5E2843732E2 FOREIGN KEY (id_station_id) REFERENCES stations (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_carburant DROP FOREIGN KEY FK_2CF7D5E2843732E2');
        $this->addSql('DROP TABLE stock_carburant');
    }
}
