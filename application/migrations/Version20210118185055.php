<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210118185055 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking_slot RENAME COLUMN row TO parking_row_id');
        $this->addSql('ALTER TABLE parking_slot ADD CONSTRAINT FK_D49A5014D7B54A6F FOREIGN KEY (parking_row_id) REFERENCES parking_row (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D49A5014D7B54A6F ON parking_slot (parking_row_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parking_slot DROP CONSTRAINT FK_D49A5014D7B54A6F');
        $this->addSql('DROP INDEX IDX_D49A5014D7B54A6F');
        $this->addSql('ALTER TABLE parking_slot RENAME COLUMN parking_row_id TO "row"');
    }
}
