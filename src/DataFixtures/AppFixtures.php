<?php

namespace App\DataFixtures;

use App\Entity\Champion;
use App\Entity\Encounter;
use App\Entity\Favorite;
use App\Entity\Img;
use App\Entity\League;
use App\Entity\Player;
use App\Entity\Post;
use App\Entity\Score;
use App\Entity\Team;
use App\Entity\Tournament;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\HttpClient\HttpClient;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $client = HttpClient::create();

        // Fetching champions data from Riot's API
        $response = $client->request('GET', "http://ddragon.leagueoflegends.com/cdn/13.10.1/data/en_US/champion.json");
        $championsData = $response->toArray();

        $champions = [];

        foreach ($championsData['data'] as $championData) {
            $champion = new Champion();
            $champion->setName($championData['name'])
                ->setDescription(implode(", ", $championData['tags']));

            // Create and add champion full image
            $imgChampionFull = new Img();
            $imgChampionFull->setUrl("http://ddragon.leagueoflegends.com/cdn/img/champion/loading/{$championData['id']}_0.jpg");
            $champion->addImage($imgChampionFull);
            $manager->persist($imgChampionFull);

            // Create and add champion sprite image
            $imgChampionSprite = new Img();
            $imgChampionSprite->setUrl("http://ddragon.leagueoflegends.com/cdn/13.10.1/img/champion/{$championData['id']}.png");
            $champion->addImage($imgChampionSprite);
            $manager->persist($imgChampionSprite);

            $manager->persist($champion);

            $champions[] = $champion;
        }

        $postsData = [

            ['Top Lane'],
            ['Jungle'],
            ['Mid Lane'],
            ['Bot Lane'],
            ['Support'],
        ];

        $leagueData = [
            [
                'name' => 'MASTERCARD NEXUS TOUR    ',
                'img' => 'https://static.riot-esports.fr/uploads/_AUTOxAUTO_crop_center-center_75_none/MNT.png',
            ],
            [
                'name' => 'DIVISION 2',
                'img' => 'https://static.riot-esports.fr/uploads/_AUTOxAUTO_crop_center-center_75_none/DIVISION2-LOGO-MAIN-BLACK-RGB.svg',
            ],
            [
                'name' => 'LA LIGUE FRANÇAISE',
                'img' => 'https://static.riot-esports.fr/uploads/_AUTOxAUTO_crop_center-center_75_none/LFL_Logo_RGF.png',
            ],
            [
                'name' => 'COMPÉTITIONS INTERNATIONALES',
                'img' => 'https://static.riot-esports.fr/uploads/_AUTOxAUTO_crop_center-center_75_none/LoLesports-Logo-competitions-inter_RGF.png',
            ]
        ];

        $teamsData = [
            [
                'name' => '100 Thieves',
                'country' => 'États-Unis',
                'img' => 'https://images.prismic.io/liguefrlol/f9a9c225-9d2c-435b-93cb-77b7f4f86152_MS_white.png?auto=compress,format',
                'players' => [
                    ['alias' => 'Tenacity', 'firstName' => 'Milan', 'lastName' => 'Oleksij'],
                    ['alias' => 'Closer', 'firstName' => 'Can', 'lastName' => 'Çelik'],
                    ['alias' => 'Bjergsen', 'firstName' => 'Søren', 'lastName' => 'Bjerg'],
                    ['alias' => 'Doublelift', 'firstName' => 'Yiliang', 'lastName' => 'Peng'],
                    ['alias' => 'Busio', 'firstName' => 'Alan', 'lastName' => 'Cwalina'],
                    ['alias' => 'Kaas', 'firstName' => 'Christophe', 'lastName' => 'van Oudheusden'],
                    ['alias' => 'Nukeduck', 'firstName' => 'Erlend', 'lastName' => 'Holm'],
                    ['alias' => 'Dan Dan', 'firstName' => 'Danny', 'lastName' => 'Le Comte'],
                ],
            ],
            [
                'name' => 'Cloud9',
                'country' => 'États-Unis',
                'img' => 'https://images.prismic.io/liguefrlol/0edbd038-b3f0-41e7-93c1-d87f5932e65d_Copy+of+logo-blanc.png?auto=compress,format',
                'players' => [
                    ['alias' => 'Fudge', 'firstName' => 'Ibrahim', 'lastName' => 'Allami'],
                    ['alias' => 'Blaber', 'firstName' => 'Robert', 'lastName' => 'Huang'],
                    ['alias' => 'Diplex', 'firstName' => 'Dimitri', 'lastName' => 'Ponomarev'],
                    ['alias' => 'EMENES', 'firstName' => 'Jang', 'lastName' => 'Min-soo'],
                    ['alias' => 'Berserker', 'firstName' => 'Kim', 'lastName' => 'Min-cheol'],
                    ['alias' => 'Zven', 'firstName' => 'Jesper', 'lastName' => 'Svenningsen'],
                    ['alias' => 'Mithy', 'firstName' => 'Alfonso', 'lastName' => 'Aguirre Rodríguez'],
                ],
            ],
            [
                'name' => 'Counter Logic Gaming',
                'country' => 'États-Unis',
                'img' => 'https://images.prismic.io/lolliguefrd2/75f7a5d4-d679-432b-a455-37edeaab46de_AkromaBlanc.png?auto=compress,format',
                'players' => [
                    ['alias' => 'Dhokla', 'firstName' => 'Niship', 'lastName' => 'Doshi'],
                    ['alias' => 'Contractz', 'firstName' => 'Juan', 'lastName' => 'Garcia'],
                    ['alias' => 'Palafox', 'firstName' => 'Cristian', 'lastName' => 'Palafox'],
                    ['alias' => 'Luger', 'firstName' => 'Fatih', 'lastName' => 'Güven'],
                    ['alias' => 'Poome', 'firstName' => 'Philippe', 'lastName' => 'Lavoie-Giguere'],
                    ['alias' => 'Thinkcard', 'firstName' => 'Thomas', 'lastName' => 'Slotkin'],
                    ['alias' => 'Croissant', 'firstName' => 'Chris', 'lastName' => 'Sun'],
                ],
            ],
            [
                'name' => 'Dignitas',
                'country' => 'États-Unis',
                'img' => 'https://images.prismic.io/liguefrlol/cdbf8cac-e27f-40ee-8ba0-94fc617e7bb2_TDS.png?auto=compress,format',
                'players' => [
                    ['alias' => 'Armut', 'firstName' => 'İrfan Berk', 'lastName' => 'Tükek'],
                    ['alias' => 'Santorin', 'firstName' => 'Lucas', 'lastName' => 'Larsen'],
                    ['alias' => 'Jensen', 'firstName' => 'Nicolaj', 'lastName' => 'Jensen'],
                    ['alias' => 'Spawn', 'firstName' => 'Trevor', 'lastName' => 'Kerr-Taylor'],
                    ['alias' => 'Tomo', 'firstName' => 'Frank', 'lastName' => 'Lam'],
                    ['alias' => 'Biofrost', 'firstName' => 'Vincent', 'lastName' => 'Wang'],
                    ['alias' => 'IgNar', 'firstName' => 'Lee', 'lastName' => 'Dong-geun'],
                    ['alias' => 'Enatron', 'firstName' => 'Ilias', 'lastName' => 'Theodorou'],
                ],
            ],
            [
                'name' => 'Evil Geniuses',
                'country' => 'États-Unis',
                'img' => 'https://images.prismic.io/liguefrlol/fb1d4db1-5f29-4d78-bb96-f07da909d40a_Logo512blanc_transparent.png?auto=compress,format',
                'players' => [
                    ['alias' => 'Ssumday', 'firstName' => 'Kim', 'lastName' => 'Chan-ho'],
                    ['alias' => 'Inspired', 'firstName' => 'Kacper', 'lastName' => 'Słoma'],
                    ['alias' => 'jojopyun', 'firstName' => 'Joseph', 'lastName' => 'Pyun'],
                    ['alias' => 'ry0ma', 'firstName' => 'Tommy', 'lastName' => 'Le'],
                    ['alias' => 'FBI', 'firstName' => 'Victor', 'lastName' => 'Huang'],
                    ['alias' => 'Vulcan', 'firstName' => 'Philippe', 'lastName' => 'Laflamme'],
                    ['alias' => 'Freeze', 'firstName' => 'Aleš', 'lastName' => 'Kněžínek'],
                    ['alias' => 'H4xDefender', 'firstName' => 'Albert', 'lastName' => 'Ong'],
                ],
            ],
            [
                'name' => 'FlyQuest',
                'country' => 'États-Unis',
                'img' => 'https://images.prismic.io/liguefrlol/7a910645-b964-4085-b8d0-e704e028b14e_klanik_color.png?auto=compress,format',
                'players' => [
                    ['alias' => 'Impact', 'firstName' => 'Jeong', 'lastName' => 'Eon-young'],
                    ['alias' => 'Spica', 'firstName' => 'Mingyi', 'lastName' => 'Lu'],
                    ['alias' => 'VicLa', 'firstName' => 'Lee', 'lastName' => 'Dae-kwang'],
                    ['alias' => 'Prince', 'firstName' => 'Lee', 'lastName' => 'Chae-hwan'],
                    ['alias' => 'Winsome', 'firstName' => 'Kim', 'lastName' => 'Dong-keon'],
                    ['alias' => 'Eyla', 'firstName' => 'Bill', 'lastName' => 'Nguyen'],
                    ['alias' => 'Ssong', 'firstName' => 'Kim', 'lastName' => 'Sang-soo'],
                    ['alias' => 'Richard', 'firstName' => 'Richard', 'lastName' => 'Su'],
                ],
            ],
            [
                'name' => 'Golden Guardians',
                'country' => 'États-Unis',
                'img' => 'https://images.prismic.io/liguefrlol/6c56c155-a9a8-4477-8321-1164bdd02f58_PCS+-+Logo+v2.png?auto=compress,format',
                'players' => [
                    ['alias' => 'Licorice', 'firstName' => 'Eric', 'lastName' => 'Ritchie'],
                    ['alias' => 'River', 'firstName' => 'Kim', 'lastName' => 'Dong-woo'],
                    ['alias' => 'Young', 'firstName' => 'Young', 'lastName' => 'Choi'],
                    ['alias' => 'Gori', 'firstName' => 'Kim', 'lastName' => 'Tae-woo'],
                    ['alias' => 'Stixxay', 'firstName' => 'Trevor', 'lastName' => 'Hayes'],
                    ['alias' => 'huhi', 'firstName' => 'Choi', 'lastName' => 'Jae-hyun'],
                    ['alias' => 'Spookz', 'firstName' => 'Samuel', 'lastName' => 'Broadley'],
                    ['alias' => 'Chuz', 'firstName' => 'Aaron', 'lastName' => 'Bland'],
                ],
            ],
            [
                'name' => 'Immortals',
                'country' => 'États-Unis',
                'img' => 'https://division2lol.fr/tournois/6362211219340877824/equipes/6362215579435474944',
                'players' => [
                    ['alias' => 'Revenge', 'firstName' => 'Mohamed', 'lastName' => 'Kaddoura'],
                    ['alias' => 'Kenvi', 'firstName' => 'Shane', 'lastName' => 'Espinoza'],
                    ['alias' => 'Ablazeolive', 'firstName' => 'Nicholas', 'lastName' => 'Abbott'],
                    ['alias' => 'Bolulu', 'firstName' => 'Onur Can', 'lastName' => 'Demirol'],
                    ['alias' => 'Tactical', 'firstName' => 'Edward', 'lastName' => 'Ra'],
                    ['alias' => 'Fleshy', 'firstName' => 'Kadir', 'lastName' => 'Kemiksiz'],
                    ['alias' => 'Mabrey', 'firstName' => 'Joshua', 'lastName' => 'Mabrey'],
                    ['alias' => 'Xmithie', 'firstName' => 'Jake', 'lastName' => 'Puchero'],
                    ['alias' => 'Summit', 'firstName' => 'Park', 'lastName' => 'Woo-tae'],
                    ['alias' => 'Pyosik', 'firstName' => 'Hong', 'lastName' => 'Chang-hyeon'],
                    ['alias' => 'Haeri', 'firstName' => 'Harry', 'lastName' => 'Kang'],
                    ['alias' => 'Yeon', 'firstName' => 'Sean', 'lastName' => 'Sung'],
                    ['alias' => 'CoreJJ', 'firstName' => 'Jo', 'lastName' => 'Yong-in'],
                    ['alias' => 'MaRin', 'firstName' => 'Jang', 'lastName' => 'Gyeong-hwan'],
                    ['alias' => 'Reignover', 'firstName' => 'Kim', 'lastName' => 'Yeu-jin'],
                    ['alias' => 'Solo', 'firstName' => 'Colin', 'lastName' => 'Earnest'],
                    ['alias' => 'Hauntzer', 'firstName' => 'Kevin', 'lastName' => 'Yarnell'],
                    ['alias' => 'Bugi', 'firstName' => 'Lee', 'lastName' => 'Seong-yeop'],
                    ['alias' => 'Maple', 'firstName' => 'Huang', 'lastName' => 'Yi-Tang'],
                    ['alias' => 'Neo', 'firstName' => 'Toàn', 'lastName' => 'Trần'],
                    ['alias' => 'WildTurtle', 'firstName' => 'Jason', 'lastName' => 'Tran'],
                    ['alias' => 'Chime', 'firstName' => 'Jonathan', 'lastName' => 'Pomponio'],
                    ['alias' => 'Chawy', 'firstName' => 'Wong', 'lastName' => 'Xing Lei'],
                ],
            ],
        ];

        $posts = [];
        foreach ($postsData as $postData) {
            $post = new Post();
            $post->setValue($postData[0]);
            $manager->persist($post);
            $posts[] = $post;
        }

        foreach ($teamsData as $teamData) {
            $team = new Team();
            $imgTeam = new Img();
            $imgTeam->setUrl($teamData['img']);
            $manager->persist($imgTeam);

            $team->setName($teamData['name'])
                ->setCountry($teamData['country'])
                ->addImage($imgTeam);
            $manager->persist($team);

            foreach ($teamData['players'] as $playerData) {
                $player = new Player();
                $player->setPseudo($playerData['alias'])
                    ->setFirstName($playerData['firstName'])
                    ->setLastName($playerData['lastName'])
                    ->setTeam($team);

                // Randomly add a champion to each player
                $randomChampionIndex = array_rand($champions);
                $randomChampion = $champions[$randomChampionIndex];
                $player->addChampion($randomChampion);

                $manager->persist($player);

                $imgPlayer = new Img();
                $imgPlayer->setUrl($faker->imageUrl());
                $player->addImage($imgPlayer);
                $manager->persist($imgPlayer);

                // Add random posts to player
                for ($j = 0; $j < 3; $j++) {
                    $randomPostIndex = array_rand($posts);
                    $randomPost = $posts[$randomPostIndex];
                    $player->setPost($randomPost);
                }
            }
        }

        $user = new User();
        $user->setEmail($faker->email)
            ->setRoles(['ROLE_USER'])
            ->setPassword($faker->password)
            ->setFirstName($faker->firstName)
            ->setLastName($faker->lastName);
        $manager->persist($user);

        foreach ($leagueData as $leagueItem) {
            $league = new League();
            $league->setName($leagueItem['name'])
                ->setStartDate($faker->dateTime)
                ->setEndDate($faker->dateTime);

            $imgLeague = new Img();
            $imgLeague->setUrl($leagueItem['img']);
            $league->addImage($imgLeague);

            $manager->persist($league);
            $manager->persist($imgLeague);
        }

        // Création des rencontres
        foreach ($tournaments as $tournament) {
            for ($i = 1; $i <= 6; $i++) {
                // Récupération aléatoire de deux équipes
                do {
                    $team1 = $teamsArray[array_rand($teamsArray)];
                    $team2 = $teamsArray[array_rand($teamsArray)];
                } while ($team1 === $team2);


                $encounter = new Encounter();
                $encounter->setTournament($tournament);
                $encounter->addTeam($team1);
                $encounter->addTeam($team2);
                $encounter->setDate($faker->dateTimeThisMonth());

                // Attribution d'un score aléatoire
                $score1 = $faker->numberBetween(0, 100);
                $score2 = $faker->numberBetween(0, 100);

                $scoreTeam1 = new Score();
                $scoreTeam1->setTeam($team1);
                $scoreTeam1->setValue($score1);
                $manager->persist($scoreTeam1);

                $scoreTeam2 = new Score();
                $scoreTeam2->setTeam($team2);
                $scoreTeam2->setValue($score2);
                $manager->persist($scoreTeam2);

                $encounter->addScore($scoreTeam1);
                $encounter->addScore($scoreTeam2);

                $manager->persist($encounter);
            }
        }

        $score = new Score();
        $score->setValue($faker->numberBetween(0, 100))
            ->setEncounter($encounter)
            ->setTeam($team);
        $manager->persist($score);

        $favorite = new Favorite();
        $favorite->setUser($user);
        $manager->persist($favorite);

        $manager->flush();
    }
}
