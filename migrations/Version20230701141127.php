<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230701141127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures_book DROP FOREIGN KEY FK_6674912916A2B381');
        $this->addSql('ALTER TABLE pictures_book DROP FOREIGN KEY FK_66749129BC415685');
        $this->addSql('DROP TABLE pictures_book');
        $this->addSql('ALTER TABLE pictures ADD book_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pictures ADD CONSTRAINT FK_8F7C2FC016A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('CREATE INDEX IDX_8F7C2FC016A2B381 ON pictures (book_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pictures_book (pictures_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_66749129BC415685 (pictures_id), INDEX IDX_6674912916A2B381 (book_id), PRIMARY KEY(pictures_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pictures_book ADD CONSTRAINT FK_6674912916A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictures_book ADD CONSTRAINT FK_66749129BC415685 FOREIGN KEY (pictures_id) REFERENCES pictures (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictures DROP FOREIGN KEY FK_8F7C2FC016A2B381');
        $this->addSql('DROP INDEX IDX_8F7C2FC016A2B381 ON pictures');
        $this->addSql('ALTER TABLE pictures DROP book_id');
    }
}
