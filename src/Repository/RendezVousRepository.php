<?php

namespace App\Repository;

use App\Entity\RendezVous;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RendezVousRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RendezVous::class);
    }

    /**
     * Retourne tous les rendez-vous d'une journée.
     */
    public function findByDay(\DateTimeImmutable $date): array
    {
        $debutJournee = $date->setTime(0, 0, 0);
        $finJournee = $date->setTime(23, 59, 59);

        return $this->createQueryBuilder('r')
            ->where('r.dateHeure BETWEEN :debut AND :fin')
            ->setParameter('debut', $debutJournee)
            ->setParameter('fin', $finJournee)
            ->orderBy('r.dateHeure', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function countAll(): int
{
    return (int) $this->createQueryBuilder('r')
        ->select('COUNT(r.id)')
        ->getQuery()
        ->getSingleScalarResult();
}
public function countToday(): int
{
    $debut = new \DateTimeImmutable('today');
    $fin = new \DateTimeImmutable('tomorrow');

    return (int) $this->createQueryBuilder('r')
        ->select('COUNT(r.id)')
        ->where('r.dateHeure >= :debut')
        ->andWhere('r.dateHeure < :fin')
        ->setParameter('debut', $debut)
        ->setParameter('fin', $fin)
        ->getQuery()
        ->getSingleScalarResult();
}

public function countByStatus(string $statut): int
{
    return (int) $this->createQueryBuilder('r')
        ->select('COUNT(r.id)')
        ->where('r.statut = :statut')
        ->setParameter('statut', $statut)
        ->getQuery()
        ->getSingleScalarResult();
}

public function findNextAppointments(int $limit = 5): array
{
    return $this->createQueryBuilder('r')
        ->where('r.dateHeure >= :now')
        ->setParameter('now', new \DateTimeImmutable())
        ->orderBy('r.dateHeure', 'ASC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}

public function findTodayAppointments(): array
{
    $debutJour = new \DateTimeImmutable('today');
    $finJour = new \DateTimeImmutable('tomorrow');

    return $this->createQueryBuilder('r')
        ->where('r.dateHeure >= :debut')
        ->andWhere('r.dateHeure < :fin')
        ->setParameter('debut', $debutJour)
        ->setParameter('fin', $finJour)
        ->orderBy('r.dateHeure', 'ASC')
        ->getQuery()
        ->getResult();
}

public function findThisWeekAppointments(): array
{
    $debut = new \DateTimeImmutable('monday this week');
    $fin = new \DateTimeImmutable('monday next week');

    return $this->createQueryBuilder('r')
        ->where('r.dateHeure >= :debut')
        ->andWhere('r.dateHeure < :fin')
        ->setParameter('debut', $debut)
        ->setParameter('fin', $fin)
        ->orderBy('r.dateHeure', 'ASC')
        ->getQuery()
        ->getResult();
}
public function findByUser($user): array
{
    return $this->createQueryBuilder('r')
        ->where('r.user = :user')
        ->setParameter('user', $user)
        ->orderBy('r.dateHeure', 'DESC')
        ->getQuery()
        ->getResult();
}
}