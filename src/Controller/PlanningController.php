<?php

namespace App\Controller;

use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        $rendezVous = $rendezVousRepository->findThisWeekAppointments();

        return $this->render('planning/index.html.twig', [
            'rendezVous' => $rendezVous,
        ]);
    }
}