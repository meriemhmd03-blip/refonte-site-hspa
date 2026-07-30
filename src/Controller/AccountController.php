<?php

namespace App\Controller;

use App\Form\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccountController extends AbstractController
{
#[Route('/account', name: 'app_account')]
#[IsGranted('ROLE_USER')]
public function index(
    Request $request,
    EntityManagerInterface $entityManager
): Response
{
    /** @var \App\Entity\User $user */
    $user = $this->getUser(); //symfony récupère l'utilisateur actuellement connecté

    $form = $this->createForm(UserProfileType::class, $user); //symfony crée automatiquement un formulaire et remplit deja les valeurs présentes dans la base

    $form->handleRequest($request); //regarde si le form a été envoyé

    if ($form->isSubmitted() && $form->isValid()) { //btn enregistrer a été cliqué ? + les données sont elles valides ?

        $entityManager->flush(); //sauvegarde les modifs // par de persist car l'utilisateur existe déjà

        $this->addFlash(
            'success',
            'Vos informations ont été mises à jour avec succès.'
        );

        return $this->redirectToRoute('app_account');
    }

    return $this->render('account/index.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
