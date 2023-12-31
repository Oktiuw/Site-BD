<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221129140138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD password VARCHAR(255) NOT NULL, DROP mdp, CHANGE email email VARCHAR(255) NOT NULL, CHANGE login login VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3AA08CB10 ON utilisateur (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1D1C63B3AA08CB10 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD mdp VARCHAR(50) NOT NULL, DROP roles, DROP password, CHANGE login login VARCHAR(50) NOT NULL, CHANGE email email VARCHAR(100) NOT NULL');
    }
}
