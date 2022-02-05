<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220204225434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lecture_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, title VARCHAR(255) NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description TEXT NOT NULL, status INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lecture (id INT NOT NULL, event_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, date DATE NOT NULL, time_start TIME(0) WITHOUT TIME ZONE NOT NULL, time_end TIME(0) WITHOUT TIME ZONE NOT NULL, description TEXT NOT NULL, speaker VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C16779483E5F2F7B ON lecture (event_id_id)');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C16779483E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lecture DROP CONSTRAINT FK_C16779483E5F2F7B');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lecture_id_seq CASCADE');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE lecture');
    }
}
