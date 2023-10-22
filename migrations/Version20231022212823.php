<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022212823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF299DED506');
        $this->addSql('DROP INDEX UNIQ_24CC0DF299DED506 ON panier');
        $this->addSql('ALTER TABLE panier CHANGE id_client_id id_client INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2E173B1B8 FOREIGN KEY (id_client) REFERENCES clients (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF2E173B1B8 ON panier (id_client)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2E173B1B8');
        $this->addSql('DROP INDEX UNIQ_24CC0DF2E173B1B8 ON panier');
        $this->addSql('ALTER TABLE panier CHANGE id_client id_client_id INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF299DED506 FOREIGN KEY (id_client_id) REFERENCES clients (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF299DED506 ON panier (id_client_id)');
    }
}
