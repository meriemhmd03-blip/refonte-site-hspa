<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PrestationRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PrestationRepository $prestationRepository): Response
{
    $prestations = $prestationRepository->findAll();

    return $this->render('home/index.html.twig', [
        'prestations' => $prestations,
    ]);
}
    #[Route('/prestations', name: 'prestations')]
public function prestations(PrestationRepository $prestationRepository): Response
{
    $prestations = $prestationRepository->findAll();

    return $this->render('home/prestations.html.twig', [
        'prestations' => $prestations,
    ]);
}

    #[Route('/prestations/{slug}', name: 'prestation_show')]
public function show(string $slug, PrestationRepository $prestationRepository): Response
{
    $prestation = $prestationRepository->findOneBy([
        'slug' => $slug
    ]);

    $prestations = $prestationRepository->findAll();

    return $this->render('home/show.html.twig', [
        'prestation' => $prestation,
        'prestations' => $prestations,
    ]);
}
   
    #[Route('/qui', name: 'qui')]
public function qui(PrestationRepository $prestationRepository): Response
{
    $prestations = $prestationRepository->findAll();

    return $this->render('home/qui.html.twig', [
        'prestations' => $prestations,
    ]);
}

    #[Route('/tarifs', name: 'tarifs')]
public function tarifs(PrestationRepository $prestationRepository): Response
{
    $prestations = $prestationRepository->findAll();

    return $this->render('home/tarifs.html.twig', [
        'prestations' => $prestations,
    ]);
}

}
