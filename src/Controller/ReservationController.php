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

final class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'app_reservation')]
    #[IsGranted('ROLE_USER')]
public function index(
    Prestation $prestation,
    Request $request,
    EntityManagerInterface $entityManager
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
}
