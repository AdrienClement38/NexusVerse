<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RankingController extends AbstractController
{
    #[Route('/ranking', name: 'app_ranking')]
    public function index(TeamRepository $teamRepository): Response
    {

        $teamRepositoryArray = $teamRepository->findAll();

        return $this->render('ranking/index.html.twig', [
            'controller_name' => 'RankingController',
            'teams' => $teamRepositoryArray,
        ]);
    }
}
