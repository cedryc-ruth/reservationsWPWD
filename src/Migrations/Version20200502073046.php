<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502073046 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE representations (id INT AUTO_INCREMENT NOT NULL, show_id INT NOT NULL, location_id INT DEFAULT NULL, schedule DATETIME NOT NULL, INDEX IDX_C90A401D0C1FC64 (show_id), INDEX IDX_C90A40164D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `shows` (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, slug VARCHAR(60) NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, poster_url VARCHAR(255) DEFAULT NULL, bookable TINYINT(1) NOT NULL, price NUMERIC(12, 2) DEFAULT NULL, INDEX IDX_6C3BF14464D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE representations ADD CONSTRAINT FK_C90A401D0C1FC64 FOREIGN KEY (show_id) REFERENCES `shows` (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE representations ADD CONSTRAINT FK_C90A40164D218E FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE `shows` ADD CONSTRAINT FK_6C3BF14464D218E FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE RESTRICT');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_5E9E89CB88823A92');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA88823A92 FOREIGN KEY (locality_id) REFERENCES localities (id)');
        $this->addSql('ALTER TABLE locations RENAME INDEX idx_5e9e89cb88823a92 TO IDX_17E64ABA88823A92');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE representations DROP FOREIGN KEY FK_C90A401D0C1FC64');
        $this->addSql('DROP TABLE representations');
        $this->addSql('DROP TABLE `shows`');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA88823A92');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_5E9E89CB88823A92 FOREIGN KEY (locality_id) REFERENCES localities (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE locations RENAME INDEX idx_17e64aba88823a92 TO IDX_5E9E89CB88823A92');
    }
}
