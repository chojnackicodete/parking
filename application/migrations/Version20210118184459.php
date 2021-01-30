<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210118184459 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking_row ADD parking_id INT NOT NULL');
        $this->addSql('ALTER TABLE parking_row ADD CONSTRAINT FK_17892793F17B2DD FOREIGN KEY (parking_id) REFERENCES parking (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17892793F17B2DD ON parking_row (parking_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parking_row DROP CONSTRAINT FK_17892793F17B2DD');
        $this->addSql('DROP INDEX IDX_17892793F17B2DD');
        $this->addSql('ALTER TABLE parking_row DROP parking_id');
    }
}
