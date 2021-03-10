<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309191237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(255) NOT NULL, ADD gover VARCHAR(255) NOT NULL, ADD img VARCHAR(255) NOT NULL, ADD special VARCHAR(255) NOT NULL, ADD etat VARCHAR(255) NOT NULL, ADD date_naiss DATE DEFAULT NULL, ADD nom_entre VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP prenom, DROP gover, DROP img, DROP special, DROP etat, DROP date_naiss, DROP nom_entre');
    }
}
