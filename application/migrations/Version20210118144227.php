<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210118144227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE parking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parking_row_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parking_slot_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vehicle_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE parking (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parking_row (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE parking_slot (id INT NOT NULL, number INT NOT NULL, size INT NOT NULL, row INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE vehicle (id INT NOT NULL, size INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE parking_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parking_row_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parking_slot_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vehicle_id_seq CASCADE');
        $this->addSql('DROP TABLE parking');
        $this->addSql('DROP TABLE parking_row');
        $this->addSql('DROP TABLE parking_slot');
        $this->addSql('DROP TABLE vehicle');
    }
}
