<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260403011210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON client');
        $this->addSql('ALTER TABLE immatriculation DROP FOREIGN KEY `FK_BE73422E19EB6921`');
        $this->addSql('DROP INDEX IDX_BE73422E19EB6921 ON immatriculation');
        $this->addSql('ALTER TABLE immatriculation DROP client_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON client (email)');
        $this->addSql('ALTER TABLE immatriculation ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE immatriculation ADD CONSTRAINT `FK_BE73422E19EB6921` FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BE73422E19EB6921 ON immatriculation (client_id)');
    }
}
