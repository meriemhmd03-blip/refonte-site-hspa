<?php

namespace App\Controller;

use App\Entity\Prestation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\RendezVous;
use App\Form\RendezVousType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Service\ReservationService;

final class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'app_reservation')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Prestation $prestation,
        Request $request,
        EntityManagerInterface $entityManager,
        ReservationService $reservationService
    ): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $rendezVous = new RendezVous();

        $rendezVous->setUser($user);
        $rendezVous->setPrestation($prestation);
        $rendezVous->setStatut('EN_ATTENTE');

        $form = $this->createForm(RendezVousType::class, $rendezVous);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$reservationService->isDateValid($rendezVous->getDateHeure())) {

                $this->addFlash(
                    'error',
                    'Impossible de réserver une date dans le passé.'
                );

                return $this->redirectToRoute(
                    'app_reservation',
                    ['id' => $prestation->getId()]
                );
            }

            if (
                !$reservationService->isBusinessHours(
                    $rendezVous->getDateHeure(),
                    $prestation->getDuree()
                )
            ) {

                $this->addFlash(
                    'error',
                    'Le salon est fermé à cette date ou à cette heure.'
                );

                return $this->redirectToRoute(
                    'app_reservation',
                    ['id' => $prestation->getId()]
                );
            }

            if (
                !$reservationService->isAvailable(
                    $rendezVous->getDateHeure(),
                    $prestation->getDuree()
                )
            ) {

                $this->addFlash(
                    'error',
                    'Ce créneau est déjà réservé.'
                );

                return $this->redirectToRoute(
                    'app_reservation',
                    ['id' => $prestation->getId()]
                );
            }

            $entityManager->persist($rendezVous);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre rendez-vous a bien été enregistré.'
            );

            return $this->redirectToRoute('app_account');
        }

        return $this->render('reservation/index.html.twig', [
            'prestation' => $prestation,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/reservation/{id}/annuler', name: 'app_reservation_cancel')]
#[IsGranted('ROLE_USER')]
public function cancel(
    RendezVous $rendezVous,
    EntityManagerInterface $entityManager
): Response
{
    /** @var \App\Entity\User $user */
    $user = $this->getUser();

    if ($rendezVous->getUser() !== $user) {
        throw $this->createAccessDeniedException();
    }

    $rendezVous->setStatut('ANNULE');

    $entityManager->flush();

    $this->addFlash(
        'success',
        'Votre rendez-vous a été annulé.'
    );

    return $this->redirectToRoute('app_account');
}
}