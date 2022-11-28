<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128170942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE canditatures (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, stage_id INT NOT NULL, pj LONGBLOB NOT NULL, INDEX IDX_B98953A8DDEAB1A3 (etudiant_id), INDEX IDX_B98953A82298D193 (stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant_groupe_etudiants (etudiant_id INT NOT NULL, groupe_etudiants_id INT NOT NULL, INDEX IDX_4D0AADFEDDEAB1A3 (etudiant_id), INDEX IDX_4D0AADFED4209702 (groupe_etudiants_id), PRIMARY KEY(etudiant_id, groupe_etudiants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_groupe_etudiants (evenement_id INT NOT NULL, groupe_etudiants_id INT NOT NULL, INDEX IDX_220906CAFD02F13 (evenement_id), INDEX IDX_220906CAD4209702 (groupe_etudiants_id), PRIMARY KEY(evenement_id, groupe_etudiants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE canditatures ADD CONSTRAINT FK_B98953A8DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE canditatures ADD CONSTRAINT FK_B98953A82298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE etudiant_groupe_etudiants ADD CONSTRAINT FK_4D0AADFEDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_groupe_etudiants ADD CONSTRAINT FK_4D0AADFED4209702 FOREIGN KEY (groupe_etudiants_id) REFERENCES groupe_etudiants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_groupe_etudiants ADD CONSTRAINT FK_220906CAFD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_groupe_etudiants ADD CONSTRAINT FK_220906CAD4209702 FOREIGN KEY (groupe_etudiants_id) REFERENCES groupe_etudiants (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE canditatures DROP FOREIGN KEY FK_B98953A8DDEAB1A3');
        $this->addSql('ALTER TABLE canditatures DROP FOREIGN KEY FK_B98953A82298D193');
        $this->addSql('ALTER TABLE etudiant_groupe_etudiants DROP FOREIGN KEY FK_4D0AADFEDDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_groupe_etudiants DROP FOREIGN KEY FK_4D0AADFED4209702');
        $this->addSql('ALTER TABLE evenement_groupe_etudiants DROP FOREIGN KEY FK_220906CAFD02F13');
        $this->addSql('ALTER TABLE evenement_groupe_etudiants DROP FOREIGN KEY FK_220906CAD4209702');
        $this->addSql('DROP TABLE canditatures');
        $this->addSql('DROP TABLE etudiant_groupe_etudiants');
        $this->addSql('DROP TABLE evenement_groupe_etudiants');
    }
}
