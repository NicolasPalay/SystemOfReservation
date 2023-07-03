<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703195304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08E836E65AE');
        $this->addSql('DROP INDEX UNIQ_F3D7A08E836E65AE ON speciality');
        $this->addSql('ALTER TABLE speciality CHANGE picutre_id picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08EEE45BDBF FOREIGN KEY (picture_id) REFERENCES pictures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3D7A08EEE45BDBF ON speciality (picture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality DROP FOREIGN KEY FK_F3D7A08EEE45BDBF');
        $this->addSql('DROP INDEX UNIQ_F3D7A08EEE45BDBF ON speciality');
        $this->addSql('ALTER TABLE speciality CHANGE picture_id picutre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08E836E65AE FOREIGN KEY (picutre_id) REFERENCES pictures (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3D7A08E836E65AE ON speciality (picutre_id)');
    }
}
