<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523084029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE champion_img (champion_id INT NOT NULL, img_id INT NOT NULL, INDEX IDX_E734E418FA7FD7EB (champion_id), INDEX IDX_E734E418C06A9F55 (img_id), PRIMARY KEY(champion_id, img_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE img (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_img (player_id INT NOT NULL, img_id INT NOT NULL, INDEX IDX_C6E3898F99E6F5DF (player_id), INDEX IDX_C6E3898FC06A9F55 (img_id), PRIMARY KEY(player_id, img_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE champion_img ADD CONSTRAINT FK_E734E418FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE champion_img ADD CONSTRAINT FK_E734E418C06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_img ADD CONSTRAINT FK_C6E3898F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_img ADD CONSTRAINT FK_C6E3898FC06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion_img DROP FOREIGN KEY FK_E734E418FA7FD7EB');
        $this->addSql('ALTER TABLE champion_img DROP FOREIGN KEY FK_E734E418C06A9F55');
        $this->addSql('ALTER TABLE player_img DROP FOREIGN KEY FK_C6E3898F99E6F5DF');
        $this->addSql('ALTER TABLE player_img DROP FOREIGN KEY FK_C6E3898FC06A9F55');
        $this->addSql('DROP TABLE champion_img');
        $this->addSql('DROP TABLE img');
        $this->addSql('DROP TABLE player_img');
    }
}
