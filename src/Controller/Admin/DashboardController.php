<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\PrestationCrudController;
use App\Controller\Admin\BienfaitCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
{
    $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

    return $this->redirect(
        $adminUrlGenerator
            ->setController(PrestationCrudController::class)
            ->generateUrl()
    );
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
}
}
