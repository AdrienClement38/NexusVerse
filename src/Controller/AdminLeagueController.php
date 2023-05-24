<?php

namespace App\Controller;

use App\Entity\League;
use App\Form\League2Type;
use App\Repository\LeagueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/league')]
class AdminLeagueController extends AbstractController
{
    #[Route('/', name: 'app_admin_league_index', methods: ['GET'])]
    public function index(LeagueRepository $leagueRepository): Response
    {
        return $this->render('adminLeague/index.html.twig', [
            'leagues' => $leagueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_league_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LeagueRepository $leagueRepository): Response
    {
        $league = new League();
        $form = $this->createForm(League2Type::class, $league);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leagueRepository->save($league, true);

            return $this->redirectToRoute('app_admin_league_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminLeague/new.html.twig', [
            'league' => $league,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_league_show', methods: ['GET'])]
    public function show(League $league): Response
    {
        return $this->render('adminLeague/show.html.twig', [
            'league' => $league,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_league_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, League $league, LeagueRepository $leagueRepository): Response
    {
        $form = $this->createForm(League2Type::class, $league);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leagueRepository->save($league, true);

            return $this->redirectToRoute('app_admin_league_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminLeague/edit.html.twig', [
            'league' => $league,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_league_delete', methods: ['POST'])]
    public function delete(Request $request, League $league, LeagueRepository $leagueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$league->getId(), $request->request->get('_token'))) {
            $leagueRepository->remove($league, true);
        }

        return $this->redirectToRoute('app_admin_league_index', [], Response::HTTP_SEE_OTHER);
    }
}
