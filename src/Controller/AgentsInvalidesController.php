<?php

namespace App\Controller;

use App\Entity\AgentsInvalides;
use App\Form\AgentsInvalidesType;
use App\Repository\AgentsInvalidesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/agents/invalides')]
#[IsGranted('ROLE_USER')]
class AgentsInvalidesController extends AbstractController
{
    #[Route('/', name: 'app_agents_invalides_index', methods: ['GET'])]
    public function index(AgentsInvalidesRepository $agentsInvalidesRepository): Response
    {
        return $this->render('agents_invalides/index.html.twig', [
            'agents_invalides' => $agentsInvalidesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_agents_invalides_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $agentsInvalide = new AgentsInvalides();
        $form = $this->createForm(AgentsInvalidesType::class, $agentsInvalide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($agentsInvalide);
            $entityManager->flush();

            return $this->redirectToRoute('app_agents_invalides_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agents_invalides/new.html.twig', [
            'agents_invalide' => $agentsInvalide,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agents_invalides_show', methods: ['GET'])]
    public function show(AgentsInvalides $agentsInvalide): Response
    {
        return $this->render('agents_invalides/show.html.twig', [
            'agents_invalide' => $agentsInvalide,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agents_invalides_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AgentsInvalides $agentsInvalide, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AgentsInvalidesType::class, $agentsInvalide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_agents_invalides_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agents_invalides/edit.html.twig', [
            'agents_invalide' => $agentsInvalide,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agents_invalides_delete', methods: ['POST'])]
    public function delete(Request $request, AgentsInvalides $agentsInvalide, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agentsInvalide->getId(), $request->request->get('_token'))) {
            $entityManager->remove($agentsInvalide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_agents_invalides_index', [], Response::HTTP_SEE_OTHER);
    }
}
