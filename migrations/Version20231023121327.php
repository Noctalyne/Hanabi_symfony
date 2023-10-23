<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023121327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients ADD nomClient VARCHAR(50) DEFAULT NULL, ADD prenomClient VARCHAR(50) DEFAULT NULL, DROP nom_client, DROP prenom_client');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients ADD nom_client VARCHAR(50) DEFAULT NULL, ADD prenom_client VARCHAR(50) DEFAULT NULL, DROP nomClient, DROP prenomClient');
    }
}
