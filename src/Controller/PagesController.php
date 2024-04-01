<?php

namespace App\Controller;

use App\Entity\Decisions;
use App\Entity\Pages;
use App\Form\PagesType;
use App\Repository\PagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/pages')]
#[IsGranted('ROLE_USER')]
class PagesController extends AbstractController
{
    #[Route('/{decision}', name: 'app_pages_index', methods: ['GET'])]
    public function index(PagesRepository $pagesRepository, Decisions $decision): Response
    {
        return $this->render('pages/index.html.twig', [
            'pages' => $pagesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pages_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $page = new Pages();
        $form = $this->createForm(PagesType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('app_pages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/new.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pages_show', methods: ['GET'])]
    public function show(Pages $page): Response
    {
        return $this->render('pages/show.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pages_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pages $page, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PagesType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pages_delete', methods: ['POST'])]
    public function delete(Request $request, Pages $page, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pages_index', [], Response::HTTP_SEE_OTHER);
    }
}
