<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023122706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients CHANGE user_password password VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE user_password password VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE vendeurs CHANGE user_password password VARCHAR(60) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients CHANGE password user_password VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE password user_password VARCHAR(60) NOT NULL');
        $this->addSql('ALTER TABLE vendeurs CHANGE password user_password VARCHAR(60) NOT NULL');
    }
}
