<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523122715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE league_img (league_id INT NOT NULL, img_id INT NOT NULL, INDEX IDX_B125F02858AFC4DE (league_id), INDEX IDX_B125F028C06A9F55 (img_id), PRIMARY KEY(league_id, img_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE league_img ADD CONSTRAINT FK_B125F02858AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE league_img ADD CONSTRAINT FK_B125F028C06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE league_img DROP FOREIGN KEY FK_B125F02858AFC4DE');
        $this->addSql('ALTER TABLE league_img DROP FOREIGN KEY FK_B125F028C06A9F55');
        $this->addSql('DROP TABLE league_img');
    }
}
