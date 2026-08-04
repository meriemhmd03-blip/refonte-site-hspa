<?php

namespace App\Controller;

use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;

class MesRendezVousController extends AbstractController
{
    #[Route('/mes-rendez-vous', name: 'app_mes_rendez_vous')]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        $rendezVous = $rendezVousRepository->findByUser(
            $this->getUser()
        );

        return $this->render('mes_rendez_vous/index.html.twig', [
            'rendezVous' => $rendezVous,
        ]);
    }
    #[Route('/mes-rendez-vous/{id}/annuler', name: 'app_annuler_rendez_vous')]
public function annuler(
    RendezVous $rendezVous,
    EntityManagerInterface $entityManager
): Response
{
    if ($rendezVous->getUser() !== $this->getUser()) {
        throw $this->createAccessDeniedException();
    }

    $rendezVous->setStatut('ANNULE');

    $entityManager->flush();

    $this->addFlash(
        'success',
        'Votre rendez-vous a bien été annulé.'
    );

    return $this->redirectToRoute('app_mes_rendez_vous');
}
}