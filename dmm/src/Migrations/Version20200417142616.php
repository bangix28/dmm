<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200417142616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD password VARCHAR(255) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD email VARCHAR(500) NOT NULL, ADD images VARCHAR(255) NOT NULL, ADD birthday DATETIME DEFAULT NULL, ADD gender VARCHAR(255) DEFAULT NULL, ADD phone_number VARCHAR(35) DEFAULT NULL COMMENT \'(DC2Type:phone_number)\', ADD last_name VARCHAR(255) NOT NULL, ADD first_name VARCHAR(255) NOT NULL, DROP te, DROP tea, DROP tee');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD te INT NOT NULL, ADD tea INT NOT NULL, ADD tee INT NOT NULL, DROP password, DROP roles, DROP email, DROP images, DROP birthday, DROP gender, DROP phone_number, DROP last_name, DROP first_name');
    }
}
