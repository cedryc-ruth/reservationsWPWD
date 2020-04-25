<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425095333 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, '
                . 'locality_id INT NOT NULL, '
                . 'slug VARCHAR(60) NOT NULL, '
                . 'designation VARCHAR(60) NOT NULL, '
                . 'address VARCHAR(255) NOT NULL, '
                . 'website VARCHAR(255) DEFAULT NULL, '
                . 'phone VARCHAR(30) DEFAULT NULL, '
                . 'INDEX IDX_5E9E89CB88823A92 (locality_id), '
                . 'PRIMARY KEY(id)) '
                . 'DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` '
                . 'ENGINE = InnoDB');
        $this->addSql('ALTER TABLE locations '
                . 'ADD CONSTRAINT FK_5E9E89CB88823A92 '
                . 'FOREIGN KEY (locality_id) '
                . 'REFERENCES localities (id) '
                . 'ON DELETE RESTRICT ON UPDATE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE locations');
    }
}
