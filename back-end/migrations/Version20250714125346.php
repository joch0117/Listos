<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250714125346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dashboard (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, task_list_id INT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, finished TINYINT(1) NOT NULL, priority INT NOT NULL, state_map VARCHAR(20) NOT NULL, INDEX IDX_93ADAABB224F3C61 (task_list_id), INDEX IDX_93ADAABBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_list (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, dashboard_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, priority INT DEFAULT NULL, INDEX IDX_377B6C63A76ED395 (user_id), INDEX IDX_377B6C63B9D04D2B (dashboard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, dashboard_id INT DEFAULT NULL, pseudo VARCHAR(75) NOT NULL, name VARCHAR(75) NOT NULL, prenom VARCHAR(75) NOT NULL, email VARCHAR(250) NOT NULL, password VARCHAR(250) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', roles JSON NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649B9D04D2B (dashboard_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE map ADD CONSTRAINT FK_93ADAABB224F3C61 FOREIGN KEY (task_list_id) REFERENCES task_list (id)');
        $this->addSql('ALTER TABLE map ADD CONSTRAINT FK_93ADAABBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task_list ADD CONSTRAINT FK_377B6C63A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task_list ADD CONSTRAINT FK_377B6C63B9D04D2B FOREIGN KEY (dashboard_id) REFERENCES dashboard (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B9D04D2B FOREIGN KEY (dashboard_id) REFERENCES dashboard (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE map DROP FOREIGN KEY FK_93ADAABB224F3C61');
        $this->addSql('ALTER TABLE map DROP FOREIGN KEY FK_93ADAABBA76ED395');
        $this->addSql('ALTER TABLE task_list DROP FOREIGN KEY FK_377B6C63A76ED395');
        $this->addSql('ALTER TABLE task_list DROP FOREIGN KEY FK_377B6C63B9D04D2B');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B9D04D2B');
        $this->addSql('DROP TABLE dashboard');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE task_list');
        $this->addSql('DROP TABLE user');
    }
}
