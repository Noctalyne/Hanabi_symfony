<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009213422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C82E74550872C ON clients');
        $this->addSql('ALTER TABLE clients CHANGE user_email useEmail VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74E45AB0AF ON clients (useEmail)');
        $this->addSql('DROP INDEX UNIQ_8D93D649550872C ON user');
        $this->addSql('ALTER TABLE user CHANGE user_email useEmail VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E45AB0AF ON user (useEmail)');
        $this->addSql('DROP INDEX UNIQ_2180DE3550872C ON vendeurs');
        $this->addSql('ALTER TABLE vendeurs CHANGE user_email useEmail VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2180DE3E45AB0AF ON vendeurs (useEmail)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C82E74E45AB0AF ON clients');
        $this->addSql('ALTER TABLE clients CHANGE useEmail user_email VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74550872C ON clients (user_email)');
        $this->addSql('DROP INDEX UNIQ_2180DE3E45AB0AF ON vendeurs');
        $this->addSql('ALTER TABLE vendeurs CHANGE useEmail user_email VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2180DE3550872C ON vendeurs (user_email)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E45AB0AF ON user');
        $this->addSql('ALTER TABLE user CHANGE useEmail user_email VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649550872C ON user (user_email)');
    }
}
