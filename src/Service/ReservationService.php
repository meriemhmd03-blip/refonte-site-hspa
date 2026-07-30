<?php

namespace App\Service;

use DateTimeImmutable;

class ReservationService
{
    public function isDateValid(DateTimeImmutable $dateHeure): bool
    {
        return $dateHeure >= new DateTimeImmutable();
    }
}