<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310002516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre CHANGE experience_max experience_max INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(255) NOT NULL, ADD gover VARCHAR(255) NOT NULL, ADD img VARCHAR(255) NOT NULL, ADD special VARCHAR(255) NOT NULL, ADD etat VARCHAR(255) NOT NULL, ADD date_naiss DATE DEFAULT NULL, ADD nom_entre VARCHAR(255) DEFAULT NULL, CHANGE name nom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre CHANGE experience_max experience_max INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP nom, DROP prenom, DROP gover, DROP img, DROP special, DROP etat, DROP date_naiss, DROP nom_entre');
    }
}
