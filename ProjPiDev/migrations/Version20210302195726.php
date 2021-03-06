<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302195726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_list ADD quiz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse_list ADD CONSTRAINT FK_78A3B15B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_78A3B15B853CD175 ON reponse_list (quiz_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_list DROP FOREIGN KEY FK_78A3B15B853CD175');
        $this->addSql('DROP INDEX IDX_78A3B15B853CD175 ON reponse_list');
        $this->addSql('ALTER TABLE reponse_list DROP quiz_id');
    }
}
