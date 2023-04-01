<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211225145919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(80) NOT NULL, name VARCHAR(80) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_groupe (user_id INT NOT NULL, group_id INT NOT NULL, INDEX IDX_61EB971CA76ED395 (user_id), INDEX IDX_61EB971CFE54D947 (group_id), PRIMARY KEY(user_id, group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_groupe ADD CONSTRAINT FK_61EB971CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_groupe ADD CONSTRAINT FK_61EB971CFE54D947 FOREIGN KEY (group_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD prenom VARCHAR(180) NOT NULL, ADD nom VARCHAR(180) NOT NULL, ADD phone_number VARCHAR(80) NOT NULL, ADD provenance VARCHAR(80) NOT NULL, ADD profile_image VARCHAR(255) NOT NULL, ADD filename VARCHAR(255) NOT NULL, ADD fonction VARCHAR(255) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD enabled TINYINT(1) NOT NULL, ADD confirmation_token VARCHAR(255) DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, ADD email_verified_at DATETIME DEFAULT NULL, DROP username');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6496B01BC5B ON user (phone_number)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_groupe DROP FOREIGN KEY FK_61EB971CFE54D947');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE user_groupe');
        $this->addSql('DROP INDEX UNIQ_8D93D6496B01BC5B ON user');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP created_at, DROP updated_at, DROP prenom, DROP nom, DROP phone_number, DROP provenance, DROP profile_image, DROP filename, DROP fonction, DROP last_login, DROP enabled, DROP confirmation_token, DROP password_requested_at, DROP email_verified_at');
    }
}
