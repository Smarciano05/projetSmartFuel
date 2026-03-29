<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311114649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pompiste (id INT AUTO_INCREMENT NOT NULL, nom_pompiste VARCHAR(255) NOT NULL, prenom_pompiste VARCHAR(255) NOT NULL, IDStations INT NOT NULL, INDEX IDX_9F26C91BF40773B6 (IDStations), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE Stations (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, nom_ville VARCHAR(255) NOT NULL, litre_essence NUMERIC(10, 2) NOT NULL, litre_diesel NUMERIC(10, 2) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE pompiste ADD CONSTRAINT FK_9F26C91BF40773B6 FOREIGN KEY (IDStations) REFERENCES Stations (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pompiste DROP FOREIGN KEY FK_9F26C91BF40773B6');
        $this->addSql('DROP TABLE pompiste');
        $this->addSql('DROP TABLE Stations');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
