<?php

namespace App\Controller\Admin;

use App\Controller\Admin\BienfaitCrudController;
use App\Controller\Admin\PrestationCrudController;
use App\Controller\Admin\RendezVousCrudController;
use App\Repository\RendezVousRepository;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private RendezVousRepository $rendezVousRepository
    ) {
    }

    public function index(): Response
    {
        $nombreRendezVous = $this->rendezVousRepository->countAll();
        $nombreAujourdHui = $this->rendezVousRepository->countToday();

        return $this->render('admin/dashboard.html.twig', [
            'nombreRendezVous' => $nombreRendezVous,
            'nombreAujourdHui' => $nombreAujourdHui,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Refonte Site Hspa');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkTo(
            PrestationCrudController::class,
            'Prestations',
            'fa fa-spa'
        );

        yield MenuItem::linkTo(
            BienfaitCrudController::class,
            'Bienfaits',
            'fa fa-leaf'
        );

        yield MenuItem::linkTo(
            RendezVousCrudController::class,
            'Rendez-vous',
            'fa fa-calendar'
        );
    }
}