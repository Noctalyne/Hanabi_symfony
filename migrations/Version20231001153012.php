<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231001153012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL, ADD user_nom VARCHAR(255) DEFAULT NULL, ADD user_prenom VARCHAR(255) DEFAULT NULL, ADD user_telephone VARCHAR(10) DEFAULT NULL, ADD user_num_adresse VARCHAR(5) DEFAULT NULL, ADD user_rue_adresse VARCHAR(150) DEFAULT NULL, ADD user_complement_adresse VARCHAR(100) DEFAULT NULL, ADD user_ville_adresse VARCHAR(50) DEFAULT NULL, ADD user_postcode_adresse VARCHAR(10) DEFAULT NULL, CHANGE roles user_role JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP username, DROP user_nom, DROP user_prenom, DROP user_telephone, DROP user_num_adresse, DROP user_rue_adresse, DROP user_complement_adresse, DROP user_ville_adresse, DROP user_postcode_adresse, CHANGE user_role roles JSON NOT NULL');
    }
}
