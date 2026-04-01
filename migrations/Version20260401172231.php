<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260401172231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('ALTER TABLE enregistrement_essence DROP FOREIGN KEY `FK_9992C49F5FD1A365`');
        $this->addSql('DROP INDEX IDX_9992C49F5FD1A365 ON enregistrement_essence');
        $this->addSql('ALTER TABLE enregistrement_essence ADD immatriculation VARCHAR(255) NOT NULL, DROP immatriculation_id');
        $this->addSql('ALTER TABLE immatriculation DROP FOREIGN KEY `FK_BE73422E19EB6921`');
        $this->addSql('DROP INDEX IDX_BE73422E19EB6921 ON immatriculation');
        $this->addSql('ALTER TABLE immatriculation DROP client_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON pompiste (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C7440455E7927C74 ON client');
        $this->addSql('ALTER TABLE enregistrement_essence ADD immatriculation_id INT NOT NULL, DROP immatriculation');
        $this->addSql('ALTER TABLE enregistrement_essence ADD CONSTRAINT `FK_9992C49F5FD1A365` FOREIGN KEY (immatriculation_id) REFERENCES immatriculation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9992C49F5FD1A365 ON enregistrement_essence (immatriculation_id)');
        $this->addSql('ALTER TABLE immatriculation ADD client_id INT NOT NULL');
        $this->addSql('ALTER TABLE immatriculation ADD CONSTRAINT `FK_BE73422E19EB6921` FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BE73422E19EB6921 ON immatriculation (client_id)');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON pompiste');
    }
}
