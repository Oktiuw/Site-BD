<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128162119 extends AbstractMigration
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
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, type_evenement_id INT NOT NULL, enseignant_id INT NOT NULL, h_deb TIME NOT NULL, h_fin TIME NOT NULL, date_evmt DATE NOT NULL, INDEX IDX_B26681E88939516 (type_evenement_id), INDEX IDX_B26681EE455FCC0 (enseignant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_etudiants (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, nom_groupe VARCHAR(255) NOT NULL, INDEX IDX_72E8D1DCB3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, lib_niv VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, niveau_id INT NOT NULL, titre_stage VARCHAR(255) NOT NULL, ad_stage VARCHAR(255) NOT NULL, cp_stage VARCHAR(255) NOT NULL, ville_stage VARCHAR(255) NOT NULL, desc_stage VARCHAR(9999) NOT NULL, INDEX IDX_C27C9369A4AEAFEA (entreprise_id), INDEX IDX_C27C9369B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sujet_ter (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, enseignant_id INT NOT NULL, etudiant_id INT DEFAULT NULL, titre_ter VARCHAR(255) NOT NULL, desc_ter VARCHAR(9999) NOT NULL, INDEX IDX_D62DEF8DB3E9C81 (niveau_id), INDEX IDX_D62DEF8DE455FCC0 (enseignant_id), INDEX IDX_D62DEF8DDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_evenement (id INT AUTO_INCREMENT NOT NULL, int_tp_evmt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, mdp VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, login VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA16E21739 FOREIGN KEY (cd_util_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA606E21739 FOREIGN KEY (cd_util_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E36E21739 FOREIGN KEY (cd_util_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E88939516 FOREIGN KEY (type_evenement_id) REFERENCES type_evenement (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE groupe_etudiants ADD CONSTRAINT FK_72E8D1DCB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE sujet_ter ADD CONSTRAINT FK_D62DEF8DB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE sujet_ter ADD CONSTRAINT FK_D62DEF8DE455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id)');
        $this->addSql('ALTER TABLE sujet_ter ADD CONSTRAINT FK_D62DEF8DDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA16E21739');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA606E21739');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E36E21739');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E88939516');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EE455FCC0');
        $this->addSql('ALTER TABLE groupe_etudiants DROP FOREIGN KEY FK_72E8D1DCB3E9C81');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A4AEAFEA');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369B3E9C81');
        $this->addSql('ALTER TABLE sujet_ter DROP FOREIGN KEY FK_D62DEF8DB3E9C81');
        $this->addSql('ALTER TABLE sujet_ter DROP FOREIGN KEY FK_D62DEF8DE455FCC0');
        $this->addSql('ALTER TABLE sujet_ter DROP FOREIGN KEY FK_D62DEF8DDDEAB1A3');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE groupe_etudiants');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE sujet_ter');
        $this->addSql('DROP TABLE type_evenement');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
