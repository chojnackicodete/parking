<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210129162836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parking_slot ADD vehicle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE parking_slot ADD CONSTRAINT FK_D49A5014545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D49A5014545317D1 ON parking_slot (vehicle_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE parking_slot DROP CONSTRAINT FK_D49A5014545317D1');
        $this->addSql('DROP INDEX IDX_D49A5014545317D1');
        $this->addSql('ALTER TABLE parking_slot DROP vehicle_id');
    }
}
