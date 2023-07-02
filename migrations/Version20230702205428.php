<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230702205428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, name_speciality VARCHAR(100) NOT NULL, duration INT NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality_hairdresser (speciality_id INT NOT NULL, hairdresser_id INT NOT NULL, INDEX IDX_74FDBD623B5A08D7 (speciality_id), INDEX IDX_74FDBD62696F8EFF (hairdresser_id), PRIMARY KEY(speciality_id, hairdresser_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE speciality_hairdresser ADD CONSTRAINT FK_74FDBD623B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speciality_hairdresser ADD CONSTRAINT FK_74FDBD62696F8EFF FOREIGN KEY (hairdresser_id) REFERENCES hairdresser (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality_hairdresser DROP FOREIGN KEY FK_74FDBD623B5A08D7');
        $this->addSql('ALTER TABLE speciality_hairdresser DROP FOREIGN KEY FK_74FDBD62696F8EFF');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE speciality_hairdresser');
    }
}
