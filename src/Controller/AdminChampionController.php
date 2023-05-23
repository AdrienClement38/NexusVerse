<?php

namespace App\Controller;

use App\Entity\Champion;
use App\Form\ChampionType;
use App\Repository\ChampionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/champion')]
class AdminChampionController extends AbstractController
{
    #[Route('/', name: 'app_admin_champion_index', methods: ['GET'])]
    public function index(ChampionRepository $championRepository): Response
    {
        return $this->render('admin_champion/index.html.twig', [
            'champions' => $championRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_champion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChampionRepository $championRepository): Response
    {
        $champion = new Champion();
        $form = $this->createForm(ChampionType::class, $champion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $championRepository->save($champion, true);

            return $this->redirectToRoute('app_admin_champion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_champion/new.html.twig', [
            'champion' => $champion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_champion_show', methods: ['GET'])]
    public function show(Champion $champion): Response
    {
        return $this->render('admin_champion/show.html.twig', [
            'champion' => $champion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_champion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Champion $champion, ChampionRepository $championRepository): Response
    {
        $form = $this->createForm(ChampionType::class, $champion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $championRepository->save($champion, true);

            return $this->redirectToRoute('app_admin_champion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_champion/edit.html.twig', [
            'champion' => $champion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_champion_delete', methods: ['POST'])]
    public function delete(Request $request, Champion $champion, ChampionRepository $championRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$champion->getId(), $request->request->get('_token'))) {
            $championRepository->remove($champion, true);
        }

        return $this->redirectToRoute('app_admin_champion_index', [], Response::HTTP_SEE_OTHER);
    }
}
