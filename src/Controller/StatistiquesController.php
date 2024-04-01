<?php

namespace App\Controller;

use App\Services\Statistiques;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class StatistiquesController extends AbstractController
{
    #[Route('/statistiques', name: 'app_statistiques')]
    public function index(Statistiques $statistiques): Response
    {
        return $this->render('statistiques/index.html.twig', [
            'userStats' => $statistiques->getUserStats('DESC'),
            'stats' => $statistiques->getStats(),
        ]);
    }
}
