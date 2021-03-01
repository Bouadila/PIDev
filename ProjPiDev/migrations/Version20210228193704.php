<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228193704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, date_naiss VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, gover VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, num VARCHAR(255) NOT NULL, special VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, cv VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidat_employeur (candidat_id INT NOT NULL, employeur_id INT NOT NULL, INDEX IDX_7708F4858D0EB82 (candidat_id), INDEX IDX_7708F4855D7C53EC (employeur_id), PRIMARY KEY(candidat_id, employeur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, titre_demande VARCHAR(255) NOT NULL, nom_cand VARCHAR(255) NOT NULL, prenom_cand VARCHAR(255) NOT NULL, email_cand VARCHAR(255) NOT NULL, num_cand VARCHAR(255) NOT NULL, adresse_cand VARCHAR(255) NOT NULL, domaine_travail VARCHAR(255) NOT NULL, statut_cand VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cv_cand VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, site_entreprise VARCHAR(255) NOT NULL, adresse_entreprise VARCHAR(255) NOT NULL, num_employeur VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, secteur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat_employeur ADD CONSTRAINT FK_7708F4858D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidat_employeur ADD CONSTRAINT FK_7708F4855D7C53EC FOREIGN KEY (employeur_id) REFERENCES employeur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat_employeur DROP FOREIGN KEY FK_7708F4858D0EB82');
        $this->addSql('ALTER TABLE candidat_employeur DROP FOREIGN KEY FK_7708F4855D7C53EC');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE candidat_employeur');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE employeur');
    }
}
