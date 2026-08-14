<?php

namespace App\Controller;

use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MesRendezVousController extends AbstractController
{
   #[Route('/mes-rendez-vous', name: 'app_mes_rendez_vous')]
#[IsGranted('ROLE_USER')]
public function index(RendezVousRepository $rendezVousRepository): Response
{
    $rendezVous = $rendezVousRepository->findByUser(
        $this->getUser()
    );

    $confirmes = 0;
    $attente = 0;
    $annules = 0;

    foreach ($rendezVous as $rdv) {

        switch ($rdv->getStatut()) {

            case 'CONFIRME':
                $confirmes++;
                break;

            case 'EN_ATTENTE':
                $attente++;
                break;

            case 'ANNULE':
                $annules++;
                break;

        }
    }

    return $this->render('mes_rendez_vous/index.html.twig', [
        'rendezVous' => $rendezVous,
        'totalRdv' => count($rendezVous),
        'confirmes' => $confirmes,
        'attente' => $attente,
        'annules' => $annules,
    ]);
}
    #[Route('/mes-rendez-vous/{id}/annuler', name: 'app_annuler_rendez_vous')]
#[IsGranted('ROLE_USER')]
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