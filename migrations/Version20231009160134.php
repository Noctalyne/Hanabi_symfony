<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009160134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INT AUTO_INCREMENT NOT NULL, num_adresse INT NOT NULL, rue_adresse VARCHAR(50) NOT NULL, complement_adresse VARCHAR(50) NOT NULL, ville_adresse VARCHAR(30) NOT NULL, cp_adresse VARCHAR(10) NOT NULL, pays_adresse VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, user_role JSON NOT NULL, user_email VARCHAR(180) NOT NULL, username VARCHAR(255) NOT NULL, user_password VARCHAR(255) NOT NULL, nom_client VARCHAR(50) DEFAULT NULL, prenom_client VARCHAR(50) DEFAULT NULL, num_telephone VARCHAR(10) DEFAULT NULL, UNIQUE INDEX UNIQ_C82E74550872C (user_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, nom_produit VARCHAR(50) NOT NULL, description_produit LONGTEXT DEFAULT NULL, img_produit VARCHAR(100) NOT NULL, prix_produit NUMERIC(6, 2) NOT NULL, quant_stock NUMERIC(3, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_role JSON NOT NULL, user_email VARCHAR(180) NOT NULL, username VARCHAR(255) NOT NULL, user_password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649550872C (user_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendeurs (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, email_user_id INT NOT NULL, user_role JSON NOT NULL, user_email VARCHAR(180) NOT NULL, username VARCHAR(255) NOT NULL, user_password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2180DE3550872C (user_email), UNIQUE INDEX UNIQ_2180DE379F37AE5 (id_user_id), UNIQUE INDEX UNIQ_2180DE31AAEBB5A (email_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vendeurs ADD CONSTRAINT FK_2180DE379F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vendeurs ADD CONSTRAINT FK_2180DE31AAEBB5A FOREIGN KEY (email_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vendeurs DROP FOREIGN KEY FK_2180DE379F37AE5');
        $this->addSql('ALTER TABLE vendeurs DROP FOREIGN KEY FK_2180DE31AAEBB5A');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vendeurs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
