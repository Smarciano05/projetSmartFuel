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

        // 5. Supprimez client_id de immatriculation (si plus nécessaire)
        $this->addSql('ALTER TABLE immatriculation DROP FOREIGN KEY FK_BE73422E19EB6921');
        $this->addSql('DROP INDEX IDX_BE73422E19EB6921 ON immatriculation');
        $this->addSql('ALTER TABLE immatriculation DROP client_id');

        // 6. Créez les index uniques surpompiste
       // $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON pompiste (email)');
    }

    public function down(Schema $schema): void
    {
        // 1. Supprime l'index unique sur pompiste.email si nécessaire
       // $this->addSql('DROP INDEX IF EXISTS UNIQ_IDENTIFIER_EMAIL ON pompiste');

        // 5. Restaurer client_id dans immatriculation
        $this->addSql('ALTER TABLE immatriculation ADD COLUMN client_id INT NOT NULL');
        $this->addSql('ALTER TABLE immatriculation ADD CONSTRAINT `FK_BE73422E19EB6921` FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BE73422E19EB6921 ON immatriculation (client_id)');
    }
}
