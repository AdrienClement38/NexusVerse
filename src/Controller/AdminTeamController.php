<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/team')]
class AdminTeamController extends AbstractController
{
    #[Route('/', name: 'app_admin_team_index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('admin_team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_team_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeamRepository $teamRepository): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);

            return $this->redirectToRoute('app_admin_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_team_show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('admin_team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_team_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);

            return $this->redirectToRoute('app_admin_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_team_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $teamRepository->remove($team, true);
        }

        return $this->redirectToRoute('app_admin_team_index', [], Response::HTTP_SEE_OTHER);
    }
}
