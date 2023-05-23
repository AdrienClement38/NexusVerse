<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523143928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team_img (team_id INT NOT NULL, img_id INT NOT NULL, INDEX IDX_E1514208296CD8AE (team_id), INDEX IDX_E1514208C06A9F55 (img_id), PRIMARY KEY(team_id, img_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team_img ADD CONSTRAINT FK_E1514208296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_img ADD CONSTRAINT FK_E1514208C06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team_img DROP FOREIGN KEY FK_E1514208296CD8AE');
        $this->addSql('ALTER TABLE team_img DROP FOREIGN KEY FK_E1514208C06A9F55');
        $this->addSql('DROP TABLE team_img');
    }
}
