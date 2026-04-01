<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260301214828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE station (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE pompiste ADD station_id INT NOT NULL');
        $this->addSql('ALTER TABLE pompiste ADD CONSTRAINT FK_9F26C91B21BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('CREATE INDEX IDX_9F26C91B21BDB235 ON pompiste (station_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE station');
        $this->addSql('ALTER TABLE pompiste DROP FOREIGN KEY FK_9F26C91B21BDB235');
        $this->addSql('DROP INDEX IDX_9F26C91B21BDB235 ON pompiste');
        $this->addSql('ALTER TABLE pompiste DROP station_id');
    }
}
