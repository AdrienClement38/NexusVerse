<?php

namespace App\Controller;

use App\Entity\League;
use App\Repository\LeagueRepository;
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

    #[Route('/{id}', name: 'app_league_show', methods: ['GET'])]
    public function show(League $league): Response
    {
        $encounters = $league->getTournament()->getEncounters();
    
        // Obtenez les équipes, la ligue, etc. à partir des rencontres
        $encountersArray = $encounters->map(function ($encounter) {
            $team1 = $encounter->getTeams()->first();
            $team2 = $encounter->getTeams()->last();
            $league = $encounter->getTournament()->getLeague();
            $score1 = $encounter->getScores()->first();
            $score2 = $encounter->getScores()->last();
            $date = $encounter->getDate();
            $tournament = $encounter->getTournament();

    
            return [
                'team1' => $team1,
                'team2' => $team2,
                'score1' => $score1,
                'score2' => $score2,
                'league' => $league,
                'date' => $date,
                'tournament' => $tournament,
            ];
        });
    
        return $this->render('league/show.html.twig', [
            'league' => $league,
            'encountersArray' => $encountersArray,            
        ]);
    }
}

