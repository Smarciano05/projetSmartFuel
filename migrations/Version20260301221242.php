<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260301221242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enregistrement_essence (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, type_carburant VARCHAR(255) NOT NULL, quantite INT NOT NULL, pompiste_id INT NOT NULL, client_id INT NOT NULL, station_id INT NOT NULL, immatriculation_id INT NOT NULL, INDEX IDX_9992C49FBE0760C4 (pompiste_id), INDEX IDX_9992C49F19EB6921 (client_id), INDEX IDX_9992C49F21BDB235 (station_id), INDEX IDX_9992C49F5FD1A365 (immatriculation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT FK_9992C49FBE0760C4 FOREIGN KEY (pompiste_id) REFERENCES pompiste (id)');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT FK_9992C49F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT FK_9992C49F21BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT FK_9992C49F5FD1A365 FOREIGN KEY (immatriculation_id) REFERENCES immatriculation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY FK_9992C49FBE0760C4');
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY FK_9992C49F19EB6921');
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY FK_9992C49F21BDB235');
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY FK_9992C49F5FD1A365');
        $this->addSql('DROP TABLE enregistrement_essence');
    }
}
