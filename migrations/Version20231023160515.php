<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023160515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, num_adresse INT NOT NULL, rue_adresse VARCHAR(50) NOT NULL, complement_adresse VARCHAR(50) NOT NULL, ville_adresse VARCHAR(30) NOT NULL, cp_adresse VARCHAR(10) NOT NULL, pays_adresse VARCHAR(30) NOT NULL, idClientAdresse INT NOT NULL, INDEX IDX_EF1925526A93C194 (idClientAdresse), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, user_role JSON NOT NULL, email VARCHAR(50) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(60) NOT NULL, nomClient VARCHAR(50) DEFAULT NULL, prenomClient VARCHAR(50) DEFAULT NULL, telephone VARCHAR(10) DEFAULT NULL, UNIQUE INDEX UNIQ_C82E74A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, date_commande DATETIME NOT NULL, liste_articles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', montant_total NUMERIC(6, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes_clients (commandes_id INT NOT NULL, clients_id INT NOT NULL, INDEX IDX_C665A6248BF5C2E6 (commandes_id), INDEX IDX_C665A624AB014612 (clients_id), PRIMARY KEY(commandes_id, clients_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formulaire_demande_produit (id INT AUTO_INCREMENT NOT NULL, type_produit VARCHAR(20) NOT NULL, description_produit VARCHAR(300) NOT NULL, date_envoie_form DATETIME NOT NULL, date_reponse_form DATETIME DEFAULT NULL, reponse_demande VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, liste_produits JSON DEFAULT NULL, prix_total NUMERIC(6, 2) NOT NULL, idClientPannier INT NOT NULL, UNIQUE INDEX UNIQ_24CC0DF271C2C69 (idClientPannier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, nom_produit VARCHAR(50) NOT NULL, description_produit LONGTEXT DEFAULT NULL, img_produit VARCHAR(100) NOT NULL, prix_produit NUMERIC(6, 2) NOT NULL, quant_stock NUMERIC(3, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_role JSON NOT NULL, email VARCHAR(50) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendeurs (id INT AUTO_INCREMENT NOT NULL, user_role JSON NOT NULL, email VARCHAR(50) NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresses ADD CONSTRAINT FK_EF1925526A93C194 FOREIGN KEY (idClientAdresse) REFERENCES clients (user_id)');
        $this->addSql('ALTER TABLE clients ADD CONSTRAINT FK_C82E74A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commandes_clients ADD CONSTRAINT FK_C665A6248BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes_clients ADD CONSTRAINT FK_C665A624AB014612 FOREIGN KEY (clients_id) REFERENCES clients (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF271C2C69 FOREIGN KEY (idClientPannier) REFERENCES clients (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresses DROP FOREIGN KEY FK_EF1925526A93C194');
        $this->addSql('ALTER TABLE clients DROP FOREIGN KEY FK_C82E74A76ED395');
        $this->addSql('ALTER TABLE commandes_clients DROP FOREIGN KEY FK_C665A6248BF5C2E6');
        $this->addSql('ALTER TABLE commandes_clients DROP FOREIGN KEY FK_C665A624AB014612');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF271C2C69');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE commandes_clients');
        $this->addSql('DROP TABLE formulaire_demande_produit');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vendeurs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
