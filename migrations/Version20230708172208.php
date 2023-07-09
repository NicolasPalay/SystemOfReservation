<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230708172208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title_book VARCHAR(100) NOT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hairdresser (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, picture_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_407D6245A76ED395 (user_id), UNIQUE INDEX UNIQ_407D6245EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8F7C2FC016A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, picture_id INT DEFAULT NULL, name_speciality VARCHAR(100) NOT NULL, duration INT NOT NULL, content LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_F3D7A08EEE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality_hairdresser (speciality_id INT NOT NULL, hairdresser_id INT NOT NULL, INDEX IDX_74FDBD623B5A08D7 (speciality_id), INDEX IDX_74FDBD62696F8EFF (hairdresser_id), PRIMARY KEY(speciality_id, hairdresser_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', full_name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hairdresser ADD CONSTRAINT FK_407D6245A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hairdresser ADD CONSTRAINT FK_407D6245EE45BDBF FOREIGN KEY (picture_id) REFERENCES pictures (id)');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC016A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08EEE45BDBF FOREIGN KEY (picture_id) REFERENCES pictures (id)');
        $this->addSql('ALTER TABLE speciality_hairdresser ADD CONSTRAINT FK_74FDBD623B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE speciality_hairdresser ADD CONSTRAINT FK_74FDBD62696F8EFF FOREIGN KEY (hairdresser_id) REFERENCES hairdresser (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hairdresser DROP FOREIGN KEY FK_407D6245A76ED395');
        $this->addSql('ALTER TABLE hairdresser DROP FOREIGN KEY FK_407D6245EE45BDBF');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC016A2B381');
        $this->addSql('ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08EEE45BDBF');
        $this->addSql('ALTER TABLE speciality_hairdresser DROP FOREIGN KEY FK_74FDBD623B5A08D7');
        $this->addSql('ALTER TABLE speciality_hairdresser DROP FOREIGN KEY FK_74FDBD62696F8EFF');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE hairdresser');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE speciality_hairdresser');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
