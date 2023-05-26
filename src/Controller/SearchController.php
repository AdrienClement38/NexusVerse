<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Team;
use App\Entity\Player;
use App\Entity\Champion;
use App\Entity\Tournament;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/search', name: 'search_results')]
    public function search(Request $request)
    {
        $query = $request->query->get('query');
        $category = $request->query->get('category');

        $results = [];

        if ($category === 'all' || $category === 'player') {
            $playerResults = $this->entityManager->getRepository(Player::class)->createQueryBuilder('p')
                ->where('p.firstName LIKE :query')
                ->orWhere('p.lastName LIKE :query')
                ->orWhere('p.pseudo LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();

            $results = array_merge($results, $playerResults);
        }

        if ($category === 'all' || $category === 'tournament') {
            $tournamentResults = $this->entityManager->getRepository(Tournament::class)->createQueryBuilder('t')
                ->where('t.name LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();

            $results = array_merge($results, $tournamentResults);
        }

        if ($category === 'all' || $category === 'league') {
            $leagueResults = $this->entityManager->getRepository(League::class)->createQueryBuilder('l')
                ->where('l.name LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();

            $results = array_merge($results, $leagueResults);
        }

        if ($category === 'all' || $category === 'team') {
            $teamResults = $this->entityManager->getRepository(Team::class)->createQueryBuilder('t')
                ->where('t.name LIKE :query')
                ->orWhere('t.country LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();

            $results = array_merge($results, $teamResults);
        }

        if ($category === 'all' || $category === 'champion') {
            $championResults = $this->entityManager->getRepository(Champion::class)->createQueryBuilder('c')
                ->where('c.name LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();

            $results = array_merge($results, $championResults);
        }

        $typedResults = [];
        foreach ($results as $result) {
            $class = ClassUtils::getClass($result);
            $typedResults[$class][] = $result;
        }

        return $this->render('search/results.html.twig', [
            'typedResults' => $typedResults,
            'results' => $results,
        ]);
    }
}