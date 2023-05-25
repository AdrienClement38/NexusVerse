<?php

namespace App\Controller;

use App\Entity\Encounter;
use App\Repository\EncounterRepository;
use App\Services\RankingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EncounterController extends AbstractController
{
    #[Route('/encounters', name: 'app_encounters')]
    public function index(): Response
    {
        return $this->render('encounter/index.html.twig', [
            'controller_name' => 'EncounterController',
        ]);
    }
    #[Route('/encounter/{id}', name: 'app_encounter_show')]
    public function show(Encounter $encounter, RankingService $rankingService): Response
    {
        $ranking = $rankingService->getWinnerAndLoser($encounter);

        return $this->render('encounter/show.html.twig', [
            'encounter' => $encounter,
            'ranking' => $ranking
        ]);
    }
}
