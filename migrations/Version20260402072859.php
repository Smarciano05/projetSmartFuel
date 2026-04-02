<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260402072859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP ville');
        $this->addSql('ALTER TABLE station ADD latitude DOUBLE PRECISION NOT NULL, ADD longitude DOUBLE PRECISION NOT NULL, DROP litre_essence, DROP litre_diesel');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD ville VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE station ADD litre_essence NUMERIC(10, 2) NOT NULL, ADD litre_diesel NUMERIC(10, 2) NOT NULL, DROP latitude, DROP longitude');
    }
}
