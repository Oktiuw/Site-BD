<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128151009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enseignant (id INT AUTO_INCREMENT NOT NULL, cd_util_id INT NOT NULL, num_en VARCHAR(50) NOT NULL, nom_en VARCHAR(100) NOT NULL, pnom_en VARCHAR(100) NOT NULL, dtns_en DATE NOT NULL, ad_en VARCHAR(255) NOT NULL, cp_en VARCHAR(10) NOT NULL, ville_en VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_81A72FA16E21739 (cd_util_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, cd_util_id INT NOT NULL, nom_ent VARCHAR(255) NOT NULL, nom_ref VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D19FA606E21739 (cd_util_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, cd_util_id INT NOT NULL, num_etud VARCHAR(20) NOT NULL, cv_etud LONGBLOB DEFAULT NULL, nom_etud VARCHAR(100) NOT NULL, pnom_etud VARCHAR(100) NOT NULL, dtns_etud DATE NOT NULL, ad_etud VARCHAR(255) NOT NULL, cp_etud VARCHAR(10) NOT NULL, ville_etud VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_717E22E36E21739 (cd_util_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, mdp VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, login VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA16E21739 FOREIGN KEY (cd_util_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA606E21739 FOREIGN KEY (cd_util_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E36E21739 FOREIGN KEY (cd_util_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA16E21739');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA606E21739');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E36E21739');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
