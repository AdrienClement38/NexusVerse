<?php

namespace App\DataFixtures;

use App\Entity\Champion;
use App\Entity\Encounter;
use App\Entity\Favorite;
use App\Entity\Img;
use App\Entity\League;
use App\Entity\Player;
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

        $teamsData = [
            [
                'name' => '100 Thieves',
                'country' => 'États-Unis',
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

        foreach ($teamsData as $teamData) {
            $team = new Team();
            $team->setName($teamData['name'])
                ->setCountry($teamData['country']);
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
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setRoles(['ROLE_USER'])
                ->setPassword($faker->password)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName);
            $manager->persist($user);

            $league = new League();
            $league->setName($faker->word)
                ->setStartDate($faker->dateTime)
                ->setEndDate($faker->dateTime);
            $manager->persist($league);

            $tournament = new Tournament();
            $tournament->setName($faker->word)
                ->setStartDate($faker->dateTime)
                ->setEndDate($faker->dateTime)
                ->setLeague($league);
            $manager->persist($tournament);

            $team = new Team();
            $team->setName($faker->company)
                ->setCountry($faker->country);
            $manager->persist($team);

            $player = new Player();
            $player->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPseudo($faker->userName)
                ->setTeam($team);
            $manager->persist($player);

            $imgPlayer = new Img();
            $imgPlayer->setUrl($faker->imageUrl());
            $player->addImage($imgPlayer);
            $manager->persist($imgPlayer);

            $encounter = new Encounter();
            $encounter->setDate($faker->dateTime)
                ->setTournament($tournament);
            $manager->persist($encounter);

            $score = new Score();
            $score->setValue($faker->numberBetween(0, 100))
                ->setEncounter($encounter)
                ->setTeam($team);
            $manager->persist($score);

            $favorite = new Favorite();
            $favorite->setUser($user);
            $manager->persist($favorite);
        }

        $manager->flush();
    }
}
