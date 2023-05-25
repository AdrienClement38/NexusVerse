<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Team;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use App\Services\RankingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/league')]
class LeagueController extends AbstractController
{
    #[Route('/', name: 'app_league_index', methods: ['GET'])]
    public function index(LeagueRepository $leagueRepository): Response
    {
        return $this->render('league/index.html.twig', [
            'leagues' => $leagueRepository->findAll(),
        ]);
    }

    // #[Route('/{id}', name: 'app_league_show', methods: ['GET'])]
    // public function show(League $league, LeagueRepository $leagueRepository, TeamRepository $teamRepository): Response
    // {
    //     //obtenir les equipes de la ligue
    //     $encounters = $league->getTournament()->getEncounters();

    //     // Obtenez les équipes, la ligue, etc. à partir des rencontres
    //     $encountersArray = $encounters->map(function ($encounter) {
    //         $team1 = $encounter->getTeams()->first();
    //         $team2 = $encounter->getTeams()->last();
    //         $score1 = $encounter->getScores()->first();
    //         $score2 = $encounter->getScores()->last();
    //         $date = $encounter->getDate();
    //         $tournament = $encounter->getTournament();


    //         return [
    //             'team1' => $team1,
    //             'team2' => $team2,
    //             'score1' => $score1,
    //             'score2' => $score2,
    //             'date' => $date,
    //             'tournament' => $tournament,
    //         ];
    //     });



    //     return $this->render('league/show.html.twig', [

    //         'league' => $league,
    //         'encountersArray' => $encountersArray,   
    //         'encounters' => $encounters,         
    //     ]);
    // }
    #[Route('/{id}', name: 'app_league_show', methods: ['GET'])]
    public function show(League $league, RankingService $rankingService): Response
    {
        $rankings = $rankingService->getLeagueResult($league);

        return $this->render('league/show.html.twig', [

            'league' => $league,
            'rankings' => $rankings,
        ]);
    }
}
