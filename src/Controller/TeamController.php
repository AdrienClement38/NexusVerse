<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/teams', name: 'app_teams')]
    public function index(TeamRepository $teamRepository): Response
    {

        $teams = $teamRepository->findAll();

        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
            'teams' => $teams,
        ]);
    }
}
