<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Team;
use App\Entity\League;
use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/favorite/add/team/{id}', name: 'add_team_favorite', methods: ['GET', 'POST'])]
    public function addTeamFavorite(Team $team, FavoriteRepository $favoriteRepository): RedirectResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'User not authenticated');
            return $this->redirectToRoute('app_login');
        }

        $favorite = $user->getFavorite();
        if (!$favorite) {
            $favorite = new Favorite();
            $user->setFavorite($favorite);
            $favoriteRepository->save($favorite, true);
        }

        if (!$favorite->hasTeam($team)) {
            $favorite->addTeam($team);
            $favoriteRepository->save($favorite, true);
            $this->addFlash('success', 'Team added to favorites');
        } else {
            $this->addFlash('info', 'Team already in favorites');
        }

        return $this->redirect($this->getRefererUrl());
    }

    #[Route('/favorite/remove/team/{id}', name: 'remove_team_favorite', methods: ['GET', 'DELETE'])]
    public function removeTeamFavorite(Team $team, FavoriteRepository $favoriteRepository): RedirectResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'User not authenticated');
            return $this->redirectToRoute('app_login');
        }

        $favorite = $user->getFavorite();
        if ($favorite && $favorite->hasTeam($team)) {
            $favorite->removeTeam($team);
            $favoriteRepository->save($favorite, true);
            $this->addFlash('success', 'Team removed from favorites');
        }

        return $this->redirect($this->getRefererUrl());
    }

    #[Route('/favorite/add/league/{id}', name: 'add_league_favorite', methods: ['GET', 'POST'])]
    public function addLeagueFavorite(League $league, FavoriteRepository $favoriteRepository): RedirectResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'User not authenticated');
            return $this->redirectToRoute('app_login');
        }

        $favorite = $user->getFavorite();
        if (!$favorite) {
            $favorite = new Favorite();
            $user->setFavorite($favorite);
            $favoriteRepository->save($favorite, true);
        }

        if (!$favorite->hasLeague($league)) {
            $favorite->addLeague($league);
            $favoriteRepository->save($favorite, true);
            $this->addFlash('success', 'League added to favorites');
        } else {
            $this->addFlash('info', 'League already in favorites');
        }

        return $this->redirect($this->getRefererUrl());
    }

    #[Route('/favorite/remove/league/{id}', name: 'remove_league_favorite', methods: ['GET', 'DELETE'])]
    public function removeLeagueFavorite(League $league, FavoriteRepository $favoriteRepository): RedirectResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'User not authenticated');
            return $this->redirectToRoute('app_login');
        }

        $favorite = $user->getFavorite();
        if ($favorite && $favorite->hasLeague($league)) {
            $favorite->removeLeague($league);
            $favoriteRepository->save($favorite, true);
            $this->addFlash('success', 'League removed from favorites');
        }

        return $this->redirect($this->getRefererUrl());
    }

    private function getRefererUrl(): string
    {
        $request = $this->requestStack->getCurrentRequest();
        return $request->headers->get('referer') ?: $this->generateUrl('app_home');
    }
}
