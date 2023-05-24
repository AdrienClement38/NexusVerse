<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524104634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE champion (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE champion_img (champion_id INT NOT NULL, img_id INT NOT NULL, INDEX IDX_E734E418FA7FD7EB (champion_id), INDEX IDX_E734E418C06A9F55 (img_id), PRIMARY KEY(champion_id, img_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE encounter (id INT AUTO_INCREMENT NOT NULL, tournament_id INT DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_69D229CA33D1A3E7 (tournament_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE encounter_team (encounter_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_DD68F77AD6E2FADC (encounter_id), INDEX IDX_DD68F77A296CD8AE (team_id), PRIMARY KEY(encounter_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_68C58ED9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_team (favorite_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_2AE6BF20AA17481D (favorite_id), INDEX IDX_2AE6BF20296CD8AE (team_id), PRIMARY KEY(favorite_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_league (favorite_id INT NOT NULL, league_id INT NOT NULL, INDEX IDX_201AFE2AA17481D (favorite_id), INDEX IDX_201AFE258AFC4DE (league_id), PRIMARY KEY(favorite_id, league_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favorite_player (favorite_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_A4AC169FAA17481D (favorite_id), INDEX IDX_A4AC169F99E6F5DF (player_id), PRIMARY KEY(favorite_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE img (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league_img (league_id INT NOT NULL, img_id INT NOT NULL, INDEX IDX_B125F02858AFC4DE (league_id), INDEX IDX_B125F028C06A9F55 (img_id), PRIMARY KEY(league_id, img_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, post_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, INDEX IDX_98197A65296CD8AE (team_id), INDEX IDX_98197A654B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_champion (player_id INT NOT NULL, champion_id INT NOT NULL, INDEX IDX_43943F5499E6F5DF (player_id), INDEX IDX_43943F54FA7FD7EB (champion_id), PRIMARY KEY(player_id, champion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_img (player_id INT NOT NULL, img_id INT NOT NULL, INDEX IDX_C6E3898F99E6F5DF (player_id), INDEX IDX_C6E3898FC06A9F55 (img_id), PRIMARY KEY(player_id, img_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score (id INT AUTO_INCREMENT NOT NULL, encounter_id INT DEFAULT NULL, team_id INT DEFAULT NULL, value INT NOT NULL, INDEX IDX_32993751D6E2FADC (encounter_id), UNIQUE INDEX UNIQ_32993751296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_img (team_id INT NOT NULL, img_id INT NOT NULL, INDEX IDX_E1514208296CD8AE (team_id), INDEX IDX_E1514208C06A9F55 (img_id), PRIMARY KEY(team_id, img_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament (id INT AUTO_INCREMENT NOT NULL, league_id INT NOT NULL, name VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_BD5FB8D958AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE champion_img ADD CONSTRAINT FK_E734E418FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE champion_img ADD CONSTRAINT FK_E734E418C06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encounter ADD CONSTRAINT FK_69D229CA33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE encounter_team ADD CONSTRAINT FK_DD68F77AD6E2FADC FOREIGN KEY (encounter_id) REFERENCES encounter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE encounter_team ADD CONSTRAINT FK_DD68F77A296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite ADD CONSTRAINT FK_68C58ED9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE favorite_team ADD CONSTRAINT FK_2AE6BF20AA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_team ADD CONSTRAINT FK_2AE6BF20296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_league ADD CONSTRAINT FK_201AFE2AA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_league ADD CONSTRAINT FK_201AFE258AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_player ADD CONSTRAINT FK_A4AC169FAA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorite_player ADD CONSTRAINT FK_A4AC169F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE league_img ADD CONSTRAINT FK_B125F02858AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE league_img ADD CONSTRAINT FK_B125F028C06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A654B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE player_champion ADD CONSTRAINT FK_43943F5499E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_champion ADD CONSTRAINT FK_43943F54FA7FD7EB FOREIGN KEY (champion_id) REFERENCES champion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_img ADD CONSTRAINT FK_C6E3898F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_img ADD CONSTRAINT FK_C6E3898FC06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751D6E2FADC FOREIGN KEY (encounter_id) REFERENCES encounter (id)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team_img ADD CONSTRAINT FK_E1514208296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_img ADD CONSTRAINT FK_E1514208C06A9F55 FOREIGN KEY (img_id) REFERENCES img (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D958AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE champion_img DROP FOREIGN KEY FK_E734E418FA7FD7EB');
        $this->addSql('ALTER TABLE champion_img DROP FOREIGN KEY FK_E734E418C06A9F55');
        $this->addSql('ALTER TABLE encounter DROP FOREIGN KEY FK_69D229CA33D1A3E7');
        $this->addSql('ALTER TABLE encounter_team DROP FOREIGN KEY FK_DD68F77AD6E2FADC');
        $this->addSql('ALTER TABLE encounter_team DROP FOREIGN KEY FK_DD68F77A296CD8AE');
        $this->addSql('ALTER TABLE favorite DROP FOREIGN KEY FK_68C58ED9A76ED395');
        $this->addSql('ALTER TABLE favorite_team DROP FOREIGN KEY FK_2AE6BF20AA17481D');
        $this->addSql('ALTER TABLE favorite_team DROP FOREIGN KEY FK_2AE6BF20296CD8AE');
        $this->addSql('ALTER TABLE favorite_league DROP FOREIGN KEY FK_201AFE2AA17481D');
        $this->addSql('ALTER TABLE favorite_league DROP FOREIGN KEY FK_201AFE258AFC4DE');
        $this->addSql('ALTER TABLE favorite_player DROP FOREIGN KEY FK_A4AC169FAA17481D');
        $this->addSql('ALTER TABLE favorite_player DROP FOREIGN KEY FK_A4AC169F99E6F5DF');
        $this->addSql('ALTER TABLE league_img DROP FOREIGN KEY FK_B125F02858AFC4DE');
        $this->addSql('ALTER TABLE league_img DROP FOREIGN KEY FK_B125F028C06A9F55');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65296CD8AE');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A654B89032C');
        $this->addSql('ALTER TABLE player_champion DROP FOREIGN KEY FK_43943F5499E6F5DF');
        $this->addSql('ALTER TABLE player_champion DROP FOREIGN KEY FK_43943F54FA7FD7EB');
        $this->addSql('ALTER TABLE player_img DROP FOREIGN KEY FK_C6E3898F99E6F5DF');
        $this->addSql('ALTER TABLE player_img DROP FOREIGN KEY FK_C6E3898FC06A9F55');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751D6E2FADC');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751296CD8AE');
        $this->addSql('ALTER TABLE team_img DROP FOREIGN KEY FK_E1514208296CD8AE');
        $this->addSql('ALTER TABLE team_img DROP FOREIGN KEY FK_E1514208C06A9F55');
        $this->addSql('ALTER TABLE tournament DROP FOREIGN KEY FK_BD5FB8D958AFC4DE');
        $this->addSql('DROP TABLE champion');
        $this->addSql('DROP TABLE champion_img');
        $this->addSql('DROP TABLE encounter');
        $this->addSql('DROP TABLE encounter_team');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE favorite_team');
        $this->addSql('DROP TABLE favorite_league');
        $this->addSql('DROP TABLE favorite_player');
        $this->addSql('DROP TABLE img');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE league_img');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_champion');
        $this->addSql('DROP TABLE player_img');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_img');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
