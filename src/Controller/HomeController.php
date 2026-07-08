<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/prestations', name: 'prestations')]
    public function prestations(): Response
    {
        return $this->render('home/prestations.html.twig');
    }
   
    #[Route('/qui', name: 'qui')]
    public function qui(): Response
    {
        return $this->render('home/qui.html.twig');
    }

    #[Route('/tarifs', name: 'tarifs')]
    public function tarifs(): Response
    {
        return $this->render('home/tarifs.html.twig');   
    }

}
