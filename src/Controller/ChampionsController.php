<?php

namespace App\Controller;

use App\Repository\ChampionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChampionsController extends AbstractController
{
    #[Route('/champions', name: 'app_champions')]
    public function index(ChampionRepository $championRepository): Response
    {

        $championRepositoryArray = $championRepository->findAll();

        return $this->render('champions/index.html.twig', [
            'controller_name' => 'ChampionsController',
            'champions' => $championRepositoryArray,
        ]);
    }
}
