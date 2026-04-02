<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260402170147 extends AbstractMigration
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
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74 ON client');
        $this->addSql('ALTER TABLE immatriculation DROP FOREIGN KEY `FK_BE73422E19EB6921`');
        $this->addSql('DROP INDEX IDX_BE73422E19EB6921 ON immatriculation');
        $this->addSql('ALTER TABLE immatriculation DROP client_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stock_carburant DROP FOREIGN KEY FK_2CF7D5E2843732E2');
        $this->addSql('DROP TABLE stock_carburant');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('ALTER TABLE immatriculation ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE immatriculation ADD CONSTRAINT `FK_BE73422E19EB6921` FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BE73422E19EB6921 ON immatriculation (client_id)');
    }
}
