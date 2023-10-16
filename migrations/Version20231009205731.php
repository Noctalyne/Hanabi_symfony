<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009205731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C82E74E7927C74 ON clients');
        $this->addSql('ALTER TABLE clients CHANGE email userEmail VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E741F76FA2 ON clients (userEmail)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user CHANGE email userEmail VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491F76FA2 ON user (userEmail)');
        $this->addSql('DROP INDEX UNIQ_2180DE3E7927C74 ON vendeurs');
        $this->addSql('ALTER TABLE vendeurs CHANGE email userEmail VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2180DE31F76FA2 ON vendeurs (userEmail)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C82E741F76FA2 ON clients');
        $this->addSql('ALTER TABLE clients CHANGE userEmail email VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74E7927C74 ON clients (email)');
        $this->addSql('DROP INDEX UNIQ_2180DE31F76FA2 ON vendeurs');
        $this->addSql('ALTER TABLE vendeurs CHANGE userEmail email VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2180DE3E7927C74 ON vendeurs (email)');
        $this->addSql('DROP INDEX UNIQ_8D93D6491F76FA2 ON user');
        $this->addSql('ALTER TABLE user CHANGE userEmail email VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
