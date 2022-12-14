<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214104701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_etudiants_etudiant (groupe_etudiants_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_119FE796D4209702 (groupe_etudiants_id), INDEX IDX_119FE796DDEAB1A3 (etudiant_id), PRIMARY KEY(groupe_etudiants_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_etudiants_etudiant ADD CONSTRAINT FK_119FE796D4209702 FOREIGN KEY (groupe_etudiants_id) REFERENCES groupe_etudiants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_etudiants_etudiant ADD CONSTRAINT FK_119FE796DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_groupe_etudiants DROP FOREIGN KEY FK_4D0AADFEDDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_groupe_etudiants DROP FOREIGN KEY FK_4D0AADFED4209702');
        $this->addSql('DROP TABLE etudiant_groupe_etudiants');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant_groupe_etudiants (etudiant_id INT NOT NULL, groupe_etudiants_id INT NOT NULL, INDEX IDX_4D0AADFED4209702 (groupe_etudiants_id), INDEX IDX_4D0AADFEDDEAB1A3 (etudiant_id), PRIMARY KEY(etudiant_id, groupe_etudiants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE etudiant_groupe_etudiants ADD CONSTRAINT FK_4D0AADFEDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_groupe_etudiants ADD CONSTRAINT FK_4D0AADFED4209702 FOREIGN KEY (groupe_etudiants_id) REFERENCES groupe_etudiants (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_etudiants_etudiant DROP FOREIGN KEY FK_119FE796D4209702');
        $this->addSql('ALTER TABLE groupe_etudiants_etudiant DROP FOREIGN KEY FK_119FE796DDEAB1A3');
        $this->addSql('DROP TABLE groupe_etudiants_etudiant');
    }
}
