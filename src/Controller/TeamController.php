<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/team', name: 'app_team')]
    public function index(PlayerRepository $playerRepository): Response
    {

        $playerRepositoryArray = $playerRepository->findAll();

        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
            'players' => $playerRepositoryArray,
        ]);
    }
}
