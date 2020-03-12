<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200302112727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE quizz_category (quizz_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(quizz_id, category_id))');
        $this->addSql('CREATE INDEX IDX_8798E5D3BA934BCD ON quizz_category (quizz_id)');
        $this->addSql('CREATE INDEX IDX_8798E5D312469DE2 ON quizz_category (category_id)');
        $this->addSql('ALTER TABLE quizz_category ADD CONSTRAINT FK_8798E5D3BA934BCD FOREIGN KEY (quizz_id) REFERENCES tbl_quizz (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quizz_category ADD CONSTRAINT FK_8798E5D312469DE2 FOREIGN KEY (category_id) REFERENCES tbl_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE quizz_category');
    }
}
