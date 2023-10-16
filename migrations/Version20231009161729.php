<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009161729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_C82E74550872C ON clients');
        $this->addSql('ALTER TABLE clients CHANGE user_email uer_email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E7463A9CCA2 ON clients (uer_email)');
        $this->addSql('DROP INDEX UNIQ_8D93D649550872C ON user');
        $this->addSql('ALTER TABLE user CHANGE user_email uer_email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64963A9CCA2 ON user (uer_email)');
        $this->addSql('DROP INDEX UNIQ_2180DE3550872C ON vendeurs');
        $this->addSql('ALTER TABLE vendeurs CHANGE user_email uer_email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2180DE363A9CCA2 ON vendeurs (uer_email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_8D93D64963A9CCA2 ON user');
        $this->addSql('ALTER TABLE user CHANGE uer_email user_email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649550872C ON user (user_email)');
        $this->addSql('DROP INDEX UNIQ_C82E7463A9CCA2 ON clients');
        $this->addSql('ALTER TABLE clients CHANGE uer_email user_email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74550872C ON clients (user_email)');
        $this->addSql('DROP INDEX UNIQ_2180DE363A9CCA2 ON vendeurs');
        $this->addSql('ALTER TABLE vendeurs CHANGE uer_email user_email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2180DE3550872C ON vendeurs (user_email)');
    }
}
