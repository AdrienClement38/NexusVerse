<?php

namespace App\Controller;

use App\Entity\Encounter;
use App\Form\EncounterType;
use App\Repository\EncounterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/encounter')]
class AdminEncounterController extends AbstractController
{
    #[Route('/', name: 'app_admin_encounter_index', methods: ['GET'])]
    public function index(EncounterRepository $encounterRepository): Response
    {
        return $this->render('admin_encounter/index.html.twig', [
            'encounters' => $encounterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_encounter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EncounterRepository $encounterRepository): Response
    {
        $encounter = new Encounter();
        $form = $this->createForm(EncounterType::class, $encounter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encounterRepository->save($encounter, true);

            $selectedTeams = $form->get('teams')->getData();

            foreach ($selectedTeams as $team) {
                $encounter->addTeam($team);
            }

            return $this->redirectToRoute('app_admin_encounter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_encounter/new.html.twig', [
            'encounter' => $encounter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_encounter_show', methods: ['GET'])]
    public function show(Encounter $encounter): Response
    {
        return $this->render('admin_encounter/show.html.twig', [
            'encounter' => $encounter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_encounter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Encounter $encounter, EncounterRepository $encounterRepository): Response
    {
        $form = $this->createForm(EncounterType::class, $encounter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encounterRepository->save($encounter, true);

            return $this->redirectToRoute('app_admin_encounter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_encounter/edit.html.twig', [
            'encounter' => $encounter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_encounter_delete', methods: ['POST'])]
    public function delete(Request $request, Encounter $encounter, EncounterRepository $encounterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$encounter->getId(), $request->request->get('_token'))) {
            $encounterRepository->remove($encounter, true);
        }

        return $this->redirectToRoute('app_admin_encounter_index', [], Response::HTTP_SEE_OTHER);
    }
}
