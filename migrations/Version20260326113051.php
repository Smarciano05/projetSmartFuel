<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260326113051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE enregistrement_essence (id INT AUTO_INCREMENT NOT NULL, type_carburant VARCHAR(255) NOT NULL, quantite INT NOT NULL, date DATETIME NOT NULL, pompiste_id INT NOT NULL, client_id INT NOT NULL, stations_id INT NOT NULL, immatriculation_id INT NOT NULL, INDEX IDX_9992C49FBE0760C4 (pompiste_id), INDEX IDX_9992C49F19EB6921 (client_id), INDEX IDX_9992C49FB1E3C4B4 (stations_id), INDEX IDX_9992C49F5FD1A365 (immatriculation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE immatriculation (id INT AUTO_INCREMENT NOT NULL, numero INT  NOT NULL, client_id INT NOT NULL, INDEX IDX_BE73422E19EB6921 (client_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT FK_9992C49FBE0760C4 FOREIGN KEY (pompiste_id) REFERENCES pompiste (id)');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT FK_9992C49F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT FK_9992C49FB1E3C4B4 FOREIGN KEY (stations_id) REFERENCES stations (id)');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT FK_9992C49F5FD1A365 FOREIGN KEY (immatriculation_id) REFERENCES immatriculation (id)');
        $this->addSql('ALTER TABLE immatriculation ADD CONSTRAINT FK_BE73422E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE pompiste DROP FOREIGN KEY `FK_9F26C91BF40773B6`');
        $this->addSql('DROP INDEX IDX_9F26C91BF40773B6 ON pompiste');
        $this->addSql('ALTER TABLE pompiste ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, DROP nom_pompiste, DROP prenom_pompiste, CHANGE IDStation stations_id INT NOT NULL');
        $this->addSql('ALTER TABLE pompiste ADD CONSTRAINT FK_9F26C91BB1E3C4B4 FOREIGN KEY (stations_id) REFERENCES stations (id)');
        $this->addSql('CREATE INDEX IDX_9F26C91BB1E3C4B4 ON pompiste (stations_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY FK_9992C49FBE0760C4');
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY FK_9992C49F19EB6921');
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY FK_9992C49FB1E3C4B4');
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY FK_9992C49F5FD1A365');
        $this->addSql('ALTER TABLE immatriculation DROP FOREIGN KEY FK_BE73422E19EB6921');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE enregistrement_essence');
        $this->addSql('DROP TABLE immatriculation');
        $this->addSql('ALTER TABLE pompiste DROP FOREIGN KEY FK_9F26C91BB1E3C4B4');
        $this->addSql('DROP INDEX IDX_9F26C91BB1E3C4B4 ON pompiste');
        $this->addSql('ALTER TABLE pompiste ADD nom_pompiste VARCHAR(255) NOT NULL, ADD prenom_pompiste VARCHAR(255) NOT NULL, DROP nom, DROP prenom, CHANGE stations_id IDStation INT NOT NULL');
        $this->addSql('ALTER TABLE pompiste ADD CONSTRAINT `FK_9F26C91BF40773B6` FOREIGN KEY (IDStation) REFERENCES stations (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9F26C91BF40773B6 ON pompiste (IDStation)');
    }
}
