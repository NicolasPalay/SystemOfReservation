<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709102650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hairdresser ADD picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hairdresser ADD CONSTRAINT FK_407D6245EE45BDBF FOREIGN KEY (picture_id) REFERENCES pictures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_407D6245EE45BDBF ON hairdresser (picture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hairdresser DROP FOREIGN KEY FK_407D6245EE45BDBF');
        $this->addSql('DROP INDEX UNIQ_407D6245EE45BDBF ON hairdresser');
        $this->addSql('ALTER TABLE hairdresser DROP picture_id');
    }
}
