<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023091423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF192552E173B1B8');
        $this->addSql('DROP INDEX IDX_EF192552E173B1B8 ON adresses');
        $this->addSql('ALTER TABLE adresses CHANGE id_client idClientAdresse INT NOT NULL');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF1925526A93C194 FOREIGN KEY (idClientAdresse) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_EF1925526A93C194 ON adresses (idClientAdresse)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2E173B1B8');
        $this->addSql('DROP INDEX UNIQ_24CC0DF2E173B1B8 ON panier');
        $this->addSql('ALTER TABLE panier CHANGE id_client idClientPannier INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF271C2C69 FOREIGN KEY (idClientPannier) REFERENCES clients (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF271C2C69 ON panier (idClientPannier)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF1925526A93C194');
        $this->addSql('DROP INDEX IDX_EF1925526A93C194 ON adresses');
        $this->addSql('ALTER TABLE adresses CHANGE idClientAdresse id_client INT NOT NULL');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF192552E173B1B8 FOREIGN KEY (id_client) REFERENCES clients (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_EF192552E173B1B8 ON adresses (id_client)');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF271C2C69');
        $this->addSql('DROP INDEX UNIQ_24CC0DF271C2C69 ON panier');
        $this->addSql('ALTER TABLE panier CHANGE idClientPannier id_client INT NOT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2E173B1B8 FOREIGN KEY (id_client) REFERENCES clients (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF2E173B1B8 ON panier (id_client)');
    }
}
