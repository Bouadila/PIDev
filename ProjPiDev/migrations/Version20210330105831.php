<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330105831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_reponses_condidat DROP FOREIGN KEY FK_37D95AC89BFF879');
        $this->addSql('DROP INDEX UNIQ_37D95AC89BFF879 ON list_reponses_condidat');
        $this->addSql('ALTER TABLE list_reponses_condidat CHANGE score score INT NOT NULL, CHANGE candidatiure_id candidature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE list_reponses_condidat ADD CONSTRAINT FK_37D95ACB6121583 FOREIGN KEY (candidature_id) REFERENCES candidature (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37D95ACB6121583 ON list_reponses_condidat (candidature_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE list_reponses_condidat DROP FOREIGN KEY FK_37D95ACB6121583');
        $this->addSql('DROP INDEX UNIQ_37D95ACB6121583 ON list_reponses_condidat');
        $this->addSql('ALTER TABLE list_reponses_condidat CHANGE score score INT DEFAULT NULL, CHANGE candidature_id candidatiure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE list_reponses_condidat ADD CONSTRAINT FK_37D95AC89BFF879 FOREIGN KEY (candidatiure_id) REFERENCES candidature (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37D95AC89BFF879 ON list_reponses_condidat (candidatiure_id)');
    }
}
