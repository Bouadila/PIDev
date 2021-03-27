<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210327183907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, nom_offer VARCHAR(255) DEFAULT NULL, offer_date VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84CC8505A');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B88D0EB82');
        $this->addSql('DROP INDEX IDX_E33BD3B88D0EB82 ON candidature');
        $this->addSql('DROP INDEX IDX_E33BD3B84CC8505A ON candidature');
        $this->addSql('ALTER TABLE candidature ADD id_quiz_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD sexe VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD num INT NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD diplome VARCHAR(255) NOT NULL, ADD cv VARCHAR(255) DEFAULT NULL, ADD id_candidat INT DEFAULT NULL, ADD id_offer INT DEFAULT NULL, ADD id_rdv INT DEFAULT NULL, ADD date_candidature DATETIME NOT NULL, DROP candidat_id, DROP offre_id, DROP note_quiz, DROP titre, CHANGE date_postuler date_naiss DATE NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B85BA17805 FOREIGN KEY (id_quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E33BD3B85BA17805 ON candidature (id_quiz_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE offer');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B85BA17805');
        $this->addSql('DROP INDEX UNIQ_E33BD3B85BA17805 ON candidature');
        $this->addSql('ALTER TABLE candidature ADD offre_id INT NOT NULL, ADD note_quiz INT NOT NULL, ADD titre VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP id_quiz_id, DROP nom, DROP prenom, DROP sexe, DROP email, DROP status, DROP diplome, DROP cv, DROP id_candidat, DROP id_offer, DROP id_rdv, DROP date_candidature, CHANGE num candidat_id INT NOT NULL, CHANGE date_naiss date_postuler DATE NOT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B88D0EB82 FOREIGN KEY (candidat_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B88D0EB82 ON candidature (candidat_id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B84CC8505A ON candidature (offre_id)');
    }
}
