<?php

namespace App\Controller;

use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
#[IsGranted('ROLE_ADMIN')]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        $rendezVous = $rendezVousRepository->findThisWeekAppointments();

        return $this->render('planning/index.html.twig', [
            'rendezVous' => $rendezVous,
        ]);
    }
}