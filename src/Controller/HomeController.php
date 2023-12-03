<?php

namespace App\Controller;

use App\Services\Statistiques;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Statistiques $statistiques): Response
    {
        return $this->render('home/index.html.twig', [
            'stats' => $statistiques->getStats(),
        ]);
    }
}
