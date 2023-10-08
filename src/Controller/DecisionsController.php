<?php

namespace App\Controller;

use App\Entity\Decisions;
use App\Form\DecisionsType;
use App\Repository\DecisionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/decisions')]
class DecisionsController extends AbstractController
{
    #[Route('/', name: 'app_decisions_index', methods: ['GET'])]
    public function index(DecisionsRepository $decisionsRepository): Response
    {
        return $this->render('decisions/index.html.twig', [
            'decisions' => $decisionsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_decisions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $decision = new Decisions();
        $form = $this->createForm(DecisionsType::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($decision);
            $entityManager->flush();

            return $this->redirectToRoute('app_decisions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('decisions/new.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_decisions_show', methods: ['GET'])]
    public function show(Decisions $decision): Response
    {
        return $this->render('decisions/show.html.twig', [
            'decision' => $decision,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_decisions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Decisions $decision, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DecisionsType::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_decisions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('decisions/edit.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_decisions_delete', methods: ['POST'])]
    public function delete(Request $request, Decisions $decision, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$decision->getId(), $request->request->get('_token'))) {
            $entityManager->remove($decision);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_decisions_index', [], Response::HTTP_SEE_OTHER);
    }
}
