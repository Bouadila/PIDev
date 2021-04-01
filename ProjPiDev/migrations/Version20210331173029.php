<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331173029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, offre_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_naiss DATE NOT NULL, num INT NOT NULL, status VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, cv VARCHAR(255) DEFAULT NULL, id_candidat INT DEFAULT NULL, date_candidature DATETIME NOT NULL, INDEX IDX_E33BD3B84CC8505A (offre_id), INDEX IDX_E33BD3B88D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, id_cand_id INT NOT NULL, titre_demande VARCHAR(255) NOT NULL, domaine_travail VARCHAR(255) NOT NULL, statut_cand VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cv_cand VARCHAR(255) NOT NULL, INDEX IDX_2694D7A5314149D3 (id_cand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE list_reponses_condidat (id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, candidature_id INT DEFAULT NULL, score INT DEFAULT NULL, INDEX IDX_37D95AC853CD175 (quiz_id), UNIQUE INDEX UNIQ_37D95ACB6121583 (candidature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, nom_offer VARCHAR(255) DEFAULT NULL, offer_date VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, contrat_id INT NOT NULL, entreprise_id INT DEFAULT NULL, quiz_id INT DEFAULT NULL, description LONGTEXT NOT NULL, salaire INT NOT NULL, date_depo DATE NOT NULL, date_expiration DATE NOT NULL, nombre_place INT NOT NULL, post VARCHAR(255) NOT NULL, objectif VARCHAR(255) NOT NULL, competences LONGTEXT NOT NULL, domaine VARCHAR(255) NOT NULL, experience_min INT NOT NULL, experience_max INT DEFAULT NULL, flag_supprimer TINYINT(1) DEFAULT NULL, flag_expirer TINYINT(1) DEFAULT NULL, INDEX IDX_AF86866F1823061F (contrat_id), INDEX IDX_AF86866FA4AEAFEA (entreprise_id), UNIQUE INDEX UNIQ_AF86866F853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_like (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_653627B84B89032C (post_id), INDEX IDX_653627B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, rep_just_id INT DEFAULT NULL, quiz_id_id INT DEFAULT NULL, contenu_ques VARCHAR(255) NOT NULL, nomb_rep INT NOT NULL, duree INT DEFAULT NULL, UNIQUE INDEX UNIQ_B6F7494E31A4897A (rep_just_id), INDEX IDX_B6F7494E8337E7D7 (quiz_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, nom_quiz VARCHAR(255) NOT NULL, nomb_question INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendezvous (id INT AUTO_INCREMENT NOT NULL, candidature_id INT NOT NULL, titre VARCHAR(100) NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, description LONGTEXT NOT NULL, all_day TINYINT(1) NOT NULL, background_color VARCHAR(7) DEFAULT NULL, border_color VARCHAR(7) DEFAULT NULL, text_color VARCHAR(7) DEFAULT NULL, accepte TINYINT(1) NOT NULL, room VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C09A9BA8B6121583 (candidature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, id_ques_id INT DEFAULT NULL, contenu_rep VARCHAR(255) NOT NULL, INDEX IDX_5FB6DEC7E359DA8E (id_ques_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_condidat (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, reponse_id INT DEFAULT NULL, list_reponses_condidat_id INT DEFAULT NULL, INDEX IDX_6506405B1E27F6BF (question_id), INDEX IDX_6506405BCF18BB82 (reponse_id), INDEX IDX_6506405B94A112E9 (list_reponses_condidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_list (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, gover VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, special VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, date_naiss DATE DEFAULT NULL, nom_entre VARCHAR(255) DEFAULT NULL, activation_token VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, id_cand_id INT NOT NULL, url VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, publish_date DATETIME NOT NULL, votes VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, domaine VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2C314149D3 (id_cand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B88D0EB82 FOREIGN KEY (candidat_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5314149D3 FOREIGN KEY (id_cand_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE list_reponses_condidat ADD CONSTRAINT FK_37D95AC853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE list_reponses_condidat ADD CONSTRAINT FK_37D95ACB6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F1823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E31A4897A FOREIGN KEY (rep_just_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E8337E7D7 FOREIGN KEY (quiz_id_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rendezvous ADD CONSTRAINT FK_C09A9BA8B6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7E359DA8E FOREIGN KEY (id_ques_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_condidat ADD CONSTRAINT FK_6506405B1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_condidat ADD CONSTRAINT FK_6506405BCF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_condidat ADD CONSTRAINT FK_6506405B94A112E9 FOREIGN KEY (list_reponses_condidat_id) REFERENCES list_reponses_condidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C314149D3 FOREIGN KEY (id_cand_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_reponses_condidat DROP FOREIGN KEY FK_37D95ACB6121583');
        $this->addSql('ALTER TABLE rendezvous DROP FOREIGN KEY FK_C09A9BA8B6121583');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F1823061F');
        $this->addSql('ALTER TABLE reponse_condidat DROP FOREIGN KEY FK_6506405B94A112E9');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84CC8505A');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7E359DA8E');
        $this->addSql('ALTER TABLE reponse_condidat DROP FOREIGN KEY FK_6506405B1E27F6BF');
        $this->addSql('ALTER TABLE list_reponses_condidat DROP FOREIGN KEY FK_37D95AC853CD175');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F853CD175');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E8337E7D7');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E31A4897A');
        $this->addSql('ALTER TABLE reponse_condidat DROP FOREIGN KEY FK_6506405BCF18BB82');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B88D0EB82');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5314149D3');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA4AEAFEA');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B8A76ED395');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C314149D3');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE list_reponses_condidat');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE rendezvous');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reponse_condidat');
        $this->addSql('DROP TABLE reponse_list');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
    }
}
