<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeagueController extends AbstractController
{
    #[Route('/league', name: 'app_league')]
    public function index(): Response
    {
        return $this->render('league/index.html.twig', [
            'controller_name' => 'LeagueController',
        ]);
    }
}
