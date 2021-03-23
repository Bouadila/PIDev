<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210306184450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, id_cand_id INT NOT NULL, titre_demande VARCHAR(255) NOT NULL, domaine_travail VARCHAR(255) NOT NULL, statut_cand VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cv_cand VARCHAR(255) NOT NULL, INDEX IDX_2694D7A5314149D3 (id_cand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, demande_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64980E95E18 (demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5314149D3 FOREIGN KEY (id_cand_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64980E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64980E95E18');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5314149D3');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE user');
    }
}
