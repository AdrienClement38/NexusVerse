<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/player')]
class AdminPlayerController extends AbstractController
{
    #[Route('/', name: 'app_player_index', methods: ['GET'])]
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('adminPlayer/index.html.twig', [
            'players' => $playerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_player_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlayerRepository $playerRepository): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playerRepository->save($player, true);

            return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminPlayer/new.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_player_show', methods: ['GET'])]
    public function show(Player $player): Response
    {
        return $this->render('adminPlayer/show.html.twig', [
            'player' => $player,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_player_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Player $player, PlayerRepository $playerRepository): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playerRepository->save($player, true);

            return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('adminPlayer/edit.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_player_delete', methods: ['POST'])]
    public function delete(Request $request, Player $player, PlayerRepository $playerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->request->get('_token'))) {
            $playerRepository->remove($player, true);
        }

        return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
    }
}
