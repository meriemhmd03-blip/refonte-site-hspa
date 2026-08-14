<?php

namespace App\Controller;

use App\Entity\RendezVous;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\MailerService;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class RendezVousAdminController extends AbstractController
{
    #[Route('/admin/rendez-vous/{id}/confirmer', name: 'app_admin_rendez_vous_confirmer')]
    #[IsGranted('ROLE_ADMIN')]
    public function confirmer(
    RendezVous $rendezVous,
    EntityManagerInterface $entityManager,
    MailerService $mailerService
): Response
    {
        $rendezVous->setStatut('CONFIRME');

        $entityManager->flush();
        $mailerService->sendConfirmationEmail($rendezVous);

        $this->addFlash(
            'success',
            'Le rendez-vous a été confirmé.'
        );

        return $this->redirectToRoute('admin');
    }

    #[Route('/admin/rendez-vous/{id}/refuser', name: 'app_admin_rendez_vous_refuser')]
    #[IsGranted('ROLE_ADMIN')]
public function refuser(
    RendezVous $rendezVous,
    EntityManagerInterface $entityManager
): Response
{
    $rendezVous->setStatut('REFUSE');

    $entityManager->flush();

    $this->addFlash(
        'success',
        'Le rendez-vous a été refusé.'
    );

    return $this->redirectToRoute('admin');
}
}