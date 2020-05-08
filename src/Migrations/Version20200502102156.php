<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502102156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE show_artist_type (show_id INT NOT NULL, artist_type_id INT NOT NULL, INDEX IDX_9F6421FED0C1FC64 (show_id), INDEX IDX_9F6421FE7203D2A4 (artist_type_id), PRIMARY KEY(show_id, artist_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE show_artist_type ADD CONSTRAINT FK_9F6421FED0C1FC64 FOREIGN KEY (show_id) REFERENCES `shows` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE show_artist_type ADD CONSTRAINT FK_9F6421FE7203D2A4 FOREIGN KEY (artist_type_id) REFERENCES artist_type (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE show_artist_type');
    }
}
