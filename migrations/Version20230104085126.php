<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104085126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidatures (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, stage_id INT NOT NULL, pj LONGBLOB DEFAULT NULL, INDEX IDX_DE57CF66DDEAB1A3 (etudiant_id), INDEX IDX_DE57CF662298D193 (stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidatures ADD CONSTRAINT FK_DE57CF66DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE candidatures ADD CONSTRAINT FK_DE57CF662298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE canditatures DROP FOREIGN KEY FK_B98953A82298D193');
        $this->addSql('ALTER TABLE canditatures DROP FOREIGN KEY FK_B98953A8DDEAB1A3');
        $this->addSql('DROP TABLE canditatures');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE canditatures (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, stage_id INT NOT NULL, pj LONGBLOB DEFAULT NULL, INDEX IDX_B98953A82298D193 (stage_id), INDEX IDX_B98953A8DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE canditatures ADD CONSTRAINT FK_B98953A82298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE canditatures ADD CONSTRAINT FK_B98953A8DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE candidatures DROP FOREIGN KEY FK_DE57CF66DDEAB1A3');
        $this->addSql('ALTER TABLE candidatures DROP FOREIGN KEY FK_DE57CF662298D193');
        $this->addSql('DROP TABLE candidatures');
    }
}
