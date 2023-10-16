<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009144803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vendeurs ADD user_role JSON NOT NULL, ADD user_email VARCHAR(180) NOT NULL, ADD username VARCHAR(255) NOT NULL, ADD user_password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2180DE3550872C ON vendeurs (user_email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_2180DE3550872C ON vendeurs');
        $this->addSql('ALTER TABLE vendeurs DROP user_role, DROP user_email, DROP username, DROP user_password');
    }
}
