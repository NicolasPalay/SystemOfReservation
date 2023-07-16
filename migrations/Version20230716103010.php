<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230716103010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD speciality_id INT DEFAULT NULL, DROP heure');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE3B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE3B5A08D7 ON booking (speciality_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE3B5A08D7');
        $this->addSql('DROP INDEX IDX_E00CEDDE3B5A08D7 ON booking');
        $this->addSql('ALTER TABLE booking ADD heure TIME DEFAULT NULL, DROP speciality_id');
    }
}
