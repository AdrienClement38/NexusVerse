<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Form\TournamentType;
use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tournament')]
class AdminTournamentController extends AbstractController
{
    #[Route('/', name: 'app_admin_tournament_index', methods: ['GET'])]
    public function index(TournamentRepository $tournamentRepository): Response
    {
        return $this->render('admin_tournament/index.html.twig', [
            'tournaments' => $tournamentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_tournament_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TournamentRepository $tournamentRepository): Response
    {
        $tournament = new Tournament();
        $form = $this->createForm(TournamentType::class, $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tournamentRepository->save($tournament, true);

            return $this->redirectToRoute('app_admin_tournament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tournament/new.html.twig', [
            'tournament' => $tournament,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tournament_show', methods: ['GET'])]
    public function show(Tournament $tournament): Response
    {
        return $this->render('admin_tournament/show.html.twig', [
            'tournament' => $tournament,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_tournament_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tournament $tournament, TournamentRepository $tournamentRepository): Response
    {
        $form = $this->createForm(TournamentType::class, $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tournamentRepository->save($tournament, true);

            return $this->redirectToRoute('app_admin_tournament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_tournament/edit.html.twig', [
            'tournament' => $tournament,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tournament_delete', methods: ['POST'])]
    public function delete(Request $request, Tournament $tournament, TournamentRepository $tournamentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tournament->getId(), $request->request->get('_token'))) {
            $tournamentRepository->remove($tournament, true);
        }

        return $this->redirectToRoute('app_admin_tournament_index', [], Response::HTTP_SEE_OTHER);
    }
}
