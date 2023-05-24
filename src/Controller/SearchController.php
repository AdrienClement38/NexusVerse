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

        // Effectuez la logique de recherche en utilisant la valeur de $query
        // Recherchez dans tous les champs des entités League, Team, Player, Champion et Tournament
        $results = [];

        // On cherche dans l'entité League
        $leagueResults = $this->entityManager->getRepository(League::class)->createQueryBuilder('l')
        ->where('l.name LIKE :query')
        ->setParameter('query', '%' . $query . '%')
        ->getQuery()
        ->getResult();

        // On ajoute les résultats de l'entité League aux résultats globaux
        $results = array_merge($results, $leagueResults);

        // On répète pour chaque entité en modifiant les champs qui nous intéresse
        $teamResults = $this->entityManager->getRepository(Team::class)->createQueryBuilder('t')
        ->where('t.name LIKE :query')
        ->orWhere('t.country LIKE :query')
        ->setParameter('query', '%' . $query . '%')
        ->getQuery()
        ->getResult();
        $results = array_merge($results, $teamResults);

        $playerResults = $this->entityManager->getRepository(Player::class)->createQueryBuilder('p')
            ->where('p.firstName LIKE :query')
            ->orWhere('p.lastName LIKE :query')
            ->orWhere('p.pseudo LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        $results = array_merge($results, $playerResults);

        $championResults = $this->entityManager->getRepository(Champion::class)->createQueryBuilder('c')
            ->where('c.name LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        $results = array_merge($results, $championResults);

        $tournamentResults = $this->entityManager->getRepository(Tournament::class)->createQueryBuilder('t')
            ->where('t.name LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
        $results = array_merge($results, $tournamentResults);

        // On récupère le type d'entité de chaque résultat
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

