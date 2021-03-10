<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307193628 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE list_reponses_condidat (id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, INDEX IDX_37D95AC853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, rep_just_id INT DEFAULT NULL, quiz_id_id INT DEFAULT NULL, contenu_ques VARCHAR(255) NOT NULL, nomb_rep INT NOT NULL, UNIQUE INDEX UNIQ_B6F7494E31A4897A (rep_just_id), INDEX IDX_B6F7494E8337E7D7 (quiz_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, nom_quiz VARCHAR(255) NOT NULL, nomb_question INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, id_ques_id INT DEFAULT NULL, contenu_rep VARCHAR(255) NOT NULL, INDEX IDX_5FB6DEC7E359DA8E (id_ques_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_condidat (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, reponse_id INT DEFAULT NULL, list_reponses_condidat_id INT DEFAULT NULL, INDEX IDX_6506405B1E27F6BF (question_id), INDEX IDX_6506405BCF18BB82 (reponse_id), INDEX IDX_6506405B94A112E9 (list_reponses_condidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse_list (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE list_reponses_condidat ADD CONSTRAINT FK_37D95AC853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E31A4897A FOREIGN KEY (rep_just_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E8337E7D7 FOREIGN KEY (quiz_id_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7E359DA8E FOREIGN KEY (id_ques_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_condidat ADD CONSTRAINT FK_6506405B1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_condidat ADD CONSTRAINT FK_6506405BCF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponse_condidat ADD CONSTRAINT FK_6506405B94A112E9 FOREIGN KEY (list_reponses_condidat_id) REFERENCES list_reponses_condidat (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL, DROP roles, CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_condidat DROP FOREIGN KEY FK_6506405B94A112E9');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7E359DA8E');
        $this->addSql('ALTER TABLE reponse_condidat DROP FOREIGN KEY FK_6506405B1E27F6BF');
        $this->addSql('ALTER TABLE list_reponses_condidat DROP FOREIGN KEY FK_37D95AC853CD175');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E8337E7D7');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E31A4897A');
        $this->addSql('ALTER TABLE reponse_condidat DROP FOREIGN KEY FK_6506405BCF18BB82');
        $this->addSql('DROP TABLE list_reponses_condidat');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reponse_condidat');
        $this->addSql('DROP TABLE reponse_list');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, DROP username, CHANGE email email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
