<?php

namespace App\Services;

use App\Entity\Encounter;
use App\Entity\League;
use App\Repository\EncounterRepository;

class RankingService
{
    private $encounterRepository;

    public function __construct(EncounterRepository $encounterRepository)
    {
        $this->encounterRepository = $encounterRepository;
    }

    /**
     * Returns an array containing the winning and losing teams and their respective scores for a given Encounter.
     *
     * @param Encounter $encounter The encounter to retrieve the winner and loser for.
     * @throws \Exception An encounter must have exactly two scores.
     * @return array An array containing the winning and losing teams and their respective scores.
     */
    public function getWinnerAndLoser(Encounter $encounter): array
    {
        $scores = $encounter->getScores();

        if (count($scores) !== 2) {
            throw new \Exception('An encounter must have exactly two scores.');
        }

        $scoresTeams = $scores->getValues();
        $scoreTeam1 = $scoresTeams[0]->getValue();
        $scoreTeam2 = $scoresTeams[1]->getValue();

        $team1 = $scoresTeams[0]->getTeam();
        $team2 = $scoresTeams[1]->getTeam();

        if ($scoreTeam1 > $scoreTeam2) {
            $winningTeam = $team1;
            $losingTeam = $team2;
            $winnerScore = $scoreTeam1;
            $loserScore = $scoreTeam2;
        } else if ($scoreTeam1 < $scoreTeam2) {
            $winningTeam = $team2;
            $losingTeam = $team1;
            $winnerScore = $scoreTeam2;
            $loserScore = $scoreTeam1;
        } else {
            // Cas d'un match nul
            return [
                'draw' => [
                    'team1' => [
                        'team' => $team1,
                        'score' => $scoreTeam1,
                    ],
                    'team2' => [
                        'team' => $team2,
                        'score' => $scoreTeam2,
                    ],
                ],
            ];
        }

        return [
            'winner' => [
                'team' => $winningTeam,
                'score' => $winnerScore,
            ],
            'loser' => [
                'team' => $losingTeam,
                'score' => $loserScore,
            ],
        ];
    }

    public function getLeagueResult(League $league): array
    {
        foreach ($league->getTournament()->getEncounters() as $encounter) {
            $result[] = $this->getWinnerAndLoser($encounter);
        }

        return $result;
    }
}
