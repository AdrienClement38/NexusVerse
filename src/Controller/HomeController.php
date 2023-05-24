<?php

namespace App\Controller;

use App\Repository\ChampionRepository;
use App\Repository\LeagueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(LeagueRepository $leagueRepository, ChampionRepository $championRepository): Response
    {

        $leagueRepositoryArray = $leagueRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'leagues' => $leagueRepositoryArray,
        ]);
    }
}
