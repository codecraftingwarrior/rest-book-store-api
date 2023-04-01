<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211225131623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD created_by INT DEFAULT NULL, ADD updated_by INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33116FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331DE12AB56 ON book (created_by)');
        $this->addSql('CREATE INDEX IDX_CBE5A33116FE72E1 ON book (updated_by)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331DE12AB56');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33116FE72E1');
        $this->addSql('DROP INDEX IDX_CBE5A331DE12AB56 ON book');
        $this->addSql('DROP INDEX IDX_CBE5A33116FE72E1 ON book');
        $this->addSql('ALTER TABLE book DROP created_by, DROP updated_by, DROP created_at, DROP updated_at');
    }
}
