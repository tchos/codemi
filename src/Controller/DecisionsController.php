<?php

namespace App\Controller;

use App\Entity\Decisions;
use App\Entity\Historiques;
use App\Form\DecisionsType;
use App\Repository\DecisionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/decisions')]
#[IsGranted('ROLE_USER')]
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
        // On capte le user connecté
        $user = $this->getUser();

        // Preparation de la table historique
        $historique = new Historiques();

        $decision = new Decisions();
        $form = $this->createForm(DecisionsType::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère le numero et la date de signature qui vont constituer le nom de la copie numérique à  stocker en bd
            $datesignature = date_format($form->get('dateSignature')->getData(), 'Ymd');
            $anneesignature = date_format($form->get('dateSignature')->getData(), 'Y');
            $numeroDecision = str_replace("/", "-", $form->get('numeroDecision')->getData());
            $ministere = $form->get('ministere')->getData();

            $copie = $form->get('copie')->getData();

            //dd($datesignature, $anneesignature, $numeroDecision, $copie);
            if($copie) {
                $newFilename = $numeroDecision . '-' . $datesignature . '-' . uniqid() . '.' . $copie->guessExtension();

                // 'copies_decisions_directory' = Chemin par défaut configuré dans le fichier service.yaml
                $chemin = $this->getParameter('copies_decisions_directory')."/".$ministere."/".$anneesignature;

                // Move the file to the directory where file are stored
                try {
                    if(is_dir($chemin)){
                        $copie->move($chemin,$newFilename);
                    }else {
                        mkdir($chemin,0777, true);
                        $copie->move($chemin,$newFilename);
                    }

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $decision->setCopie($newFilename)
                        ->setUserDecision($user);

                $historique->setTypeAction("CREATE")
                    ->setAuteur($user->getUsername())
                    ->setNature("DECISION")
                    ->setClef($form->get('numeroDecision')->getData())
                    ->setDateAction(new \DateTimeImmutable());

                // Alerte succès de l'enregistrement d'une décision
                $this->addFlash(
                    'success',
                    'La décision n° {$numeroDecision} a été enregistrée avec succès !'
                );
                //dd($chemin,$newFilename);

                $entityManager->persist($decision);
                $entityManager->persist($historique);
                $entityManager->flush();
            }

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
