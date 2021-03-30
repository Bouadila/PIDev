<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330103224 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_reponses_condidat ADD candidatiure_id INT DEFAULT NULL, ADD score INT NOT NULL');
        $this->addSql('ALTER TABLE list_reponses_condidat ADD CONSTRAINT FK_37D95AC89BFF879 FOREIGN KEY (candidatiure_id) REFERENCES candidature (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37D95AC89BFF879 ON list_reponses_condidat (candidatiure_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_reponses_condidat DROP FOREIGN KEY FK_37D95AC89BFF879');
        $this->addSql('DROP INDEX UNIQ_37D95AC89BFF879 ON list_reponses_condidat');
        $this->addSql('ALTER TABLE list_reponses_condidat DROP candidatiure_id, DROP score');
    }
}
