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
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\RendezVousRepository;

final class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation_choix')]
#[IsGranted('ROLE_USER')]
public function choix(
    \App\Repository\PrestationRepository $prestationRepository
): Response
{
    return $this->render('reservation/choix.html.twig', [
        'prestations' => $prestationRepository->findAll(),
    ]);
}
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

            return $this->redirectToRoute('app_mes_rendez_vous');
        }

        return $this->render('reservation/index.html.twig', [
            'prestation' => $prestation,
            'form' => $form->createView(),
        ]);
    }


#[Route('/reservation/creneaux/{date}', name: 'app_creneaux')]
#[IsGranted('ROLE_USER')]
public function creneaux(
    string $date,
    RendezVousRepository $repository
): JsonResponse
{
    $debut = new \DateTime($date . ' 00:00:00');
    $fin = new \DateTime($date . ' 23:59:59');

    $rendezVous = $repository->createQueryBuilder('r')
        ->where('r.dateHeure BETWEEN :debut AND :fin')
        ->andWhere('r.statut != :annule')
        ->setParameter('debut', $debut)
        ->setParameter('fin', $fin)
        ->setParameter('annule', 'ANNULE')
        ->getQuery()
        ->getResult();

    $heures = [];

    foreach ($rendezVous as $rdv) {
        $heures[] = $rdv->getDateHeure()->format('H:i');
    }

    return new JsonResponse($heures);
}
}