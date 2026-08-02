<?php

namespace App\Service;

use App\Entity\RendezVous;
use App\Repository\RendezVousRepository;
use DateTimeImmutable;

class ReservationService
{
    public function __construct(
        private RendezVousRepository $rendezVousRepository
    ) {
    }

    public function isDateValid(?DateTimeImmutable $dateHeure): bool
    {
        if ($dateHeure === null) {
            return false;
        }

        return $dateHeure >= new DateTimeImmutable();
    }

    public function isBusinessHours(
    DateTimeImmutable $dateHeure,
    int $duree
): bool
{
    $jour = (int) $dateHeure->format('N');

    // Fermé lundi (1) et dimanche (7)
    if ($jour === 1 || $jour === 7) {
        return false;
    }

    $ouverture = $dateHeure->setTime(9, 0);
    $fermeture = $dateHeure->setTime(19, 0);

    $finSoin = $dateHeure->modify("+{$duree} minutes");

    return $dateHeure >= $ouverture
        && $finSoin <= $fermeture;
}

    public function isAvailable(DateTimeImmutable $dateHeure, int $duree): bool
    {
        $finNouveau = $dateHeure->modify("+{$duree} minutes");

        $rendezVousDuJour = $this->rendezVousRepository->findByDay($dateHeure);

        foreach ($rendezVousDuJour as $rendezVous) {

            $debutExistant = $rendezVous->getDateHeure();

            $finExistant = $debutExistant->modify(
                '+' . $rendezVous->getPrestation()->getDuree() . ' minutes'
            );

            if (
                $dateHeure < $finExistant &&
                $finNouveau > $debutExistant
            ) {
                return false;
            }
        }

        return true;
    }
}