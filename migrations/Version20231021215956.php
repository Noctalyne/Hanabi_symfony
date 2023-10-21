<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231021215956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses ADD id_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF19255299DED506 FOREIGN KEY (id_client_id) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_EF19255299DED506 ON adresses (id_client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF19255299DED506');
        $this->addSql('DROP INDEX IDX_EF19255299DED506 ON adresses');
        $this->addSql('ALTER TABLE adresses DROP id_client_id');
    }
}
