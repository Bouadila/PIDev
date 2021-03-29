<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329122654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, id_cand_id INT NOT NULL, titre_demande VARCHAR(255) NOT NULL, domaine_travail VARCHAR(255) NOT NULL, statut_cand VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cv_cand VARCHAR(255) NOT NULL, INDEX IDX_2694D7A5314149D3 (id_cand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, nom_offer VARCHAR(255) DEFAULT NULL, offer_date VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_like (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_653627B84B89032C (post_id), INDEX IDX_653627B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, id_cand_id INT NOT NULL, url VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, publish_date DATETIME NOT NULL, votes VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, domaine VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2C314149D3 (id_cand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5314149D3 FOREIGN KEY (id_cand_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C314149D3 FOREIGN KEY (id_cand_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84CC8505A');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B88D0EB82');
        $this->addSql('DROP INDEX IDX_E33BD3B88D0EB82 ON candidature');
        $this->addSql('DROP INDEX IDX_E33BD3B84CC8505A ON candidature');
        $this->addSql('ALTER TABLE candidature ADD id_quiz_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD sexe VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD num INT NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD diplome VARCHAR(255) NOT NULL, ADD cv VARCHAR(255) DEFAULT NULL, ADD id_candidat INT DEFAULT NULL, ADD id_offer INT DEFAULT NULL, ADD id_rdv INT DEFAULT NULL, ADD date_candidature DATETIME NOT NULL, DROP candidat_id, DROP offre_id, DROP note_quiz, DROP titre, CHANGE date_postuler date_naiss DATE NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B85BA17805 FOREIGN KEY (id_quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E33BD3B85BA17805 ON candidature (id_quiz_id)');
        $this->addSql('ALTER TABLE question ADD duree INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendezvous DROP accepte, DROP room');
        $this->addSql('ALTER TABLE user ADD activation_token VARCHAR(255) DEFAULT NULL, ADD reset_token VARCHAR(255) DEFAULT NULL, ADD color VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE video');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B85BA17805');
        $this->addSql('DROP INDEX UNIQ_E33BD3B85BA17805 ON candidature');
        $this->addSql('ALTER TABLE candidature ADD offre_id INT NOT NULL, ADD note_quiz INT NOT NULL, ADD titre VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP id_quiz_id, DROP nom, DROP prenom, DROP sexe, DROP email, DROP status, DROP diplome, DROP cv, DROP id_candidat, DROP id_offer, DROP id_rdv, DROP date_candidature, CHANGE num candidat_id INT NOT NULL, CHANGE date_naiss date_postuler DATE NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B88D0EB82 FOREIGN KEY (candidat_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B88D0EB82 ON candidature (candidat_id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B84CC8505A ON candidature (offre_id)');
        $this->addSql('ALTER TABLE question DROP duree');
        $this->addSql('ALTER TABLE rendezvous ADD accepte TINYINT(1) NOT NULL, ADD room VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP activation_token, DROP reset_token, DROP color, DROP created_at');
    }
}
