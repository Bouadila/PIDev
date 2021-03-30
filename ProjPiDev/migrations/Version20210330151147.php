<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330151147 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, id_quiz_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_naiss DATE NOT NULL, num INT NOT NULL, status VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, cv VARCHAR(255) DEFAULT NULL, id_candidat INT DEFAULT NULL, id_offer INT DEFAULT NULL, id_rdv INT DEFAULT NULL, date_candidature DATETIME NOT NULL, UNIQUE INDEX UNIQ_E33BD3B85BA17805 (id_quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B85BA17805 FOREIGN KEY (id_quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5314149D3 FOREIGN KEY (id_cand_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_like CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question ADD duree INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendezvous DROP accepte, DROP room');
        $this->addSql('ALTER TABLE video CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C314149D3 FOREIGN KEY (id_cand_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C314149D3 ON video (id_cand_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA8B6121583');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5314149D3');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B8A76ED395');
        $this->addSql('ALTER TABLE post_like CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE question DROP duree');
        $this->addSql('ALTER TABLE rendezvous ADD accepte TINYINT(1) NOT NULL, ADD room VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE video MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C314149D3');
        $this->addSql('DROP INDEX IDX_7CC7DA2C314149D3 ON video');
        $this->addSql('ALTER TABLE video DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE video CHANGE id id INT NOT NULL');
    }
}
