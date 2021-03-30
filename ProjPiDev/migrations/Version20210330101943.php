<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330101943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B85BA17805');
        $this->addSql('DROP INDEX UNIQ_E33BD3B85BA17805 ON candidature');
        $this->addSql('ALTER TABLE candidature ADD offre_id INT DEFAULT NULL, DROP id_quiz_id, DROP id_offer');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('CREATE INDEX IDX_E33BD3B84CC8505A ON candidature (offre_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B84CC8505A');
        $this->addSql('DROP INDEX IDX_E33BD3B84CC8505A ON candidature');
        $this->addSql('ALTER TABLE candidature ADD id_offer INT DEFAULT NULL, CHANGE offre_id id_quiz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B85BA17805 FOREIGN KEY (id_quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E33BD3B85BA17805 ON candidature (id_quiz_id)');
    }
}
