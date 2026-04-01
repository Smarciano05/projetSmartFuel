<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260401161558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock_carburant (id INT AUTO_INCREMENT NOT NULL, type_carburant VARCHAR(255) NOT NULL, qte_carburant DOUBLE PRECISION NOT NULL, id_station_id INT NOT NULL, INDEX IDX_2CF7D5E2843732E2 (id_station_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE stock_carburant ADD CONSTRAINT FK_2CF7D5E2843732E2 FOREIGN KEY (id_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE client ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL, ADD numero INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON client (email)');
        $this->addSql('ALTER TABLE pompiste RENAME INDEX uniq_9f26c91be7927c74 TO UNIQ_IDENTIFIER_EMAIL');
        $this->addSql('ALTER TABLE station ADD nom_ville VARCHAR(255) NOT NULL, ADD litre_essence NUMERIC(10, 2) NOT NULL, ADD litre_diesel NUMERIC(10, 2) NOT NULL, DROP latitude, DROP longitude');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_carburant DROP FOREIGN KEY FK_2CF7D5E2843732E2');
        $this->addSql('DROP TABLE stock_carburant');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON client');
        $this->addSql('ALTER TABLE client DROP email, DROP roles, DROP password, DROP ville, DROP numero');
        $this->addSql('ALTER TABLE pompiste RENAME INDEX uniq_identifier_email TO UNIQ_9F26C91BE7927C74');
        $this->addSql('ALTER TABLE station ADD latitude DOUBLE PRECISION NOT NULL, ADD longitude DOUBLE PRECISION NOT NULL, DROP nom_ville, DROP litre_essence, DROP litre_diesel');
    }
}
