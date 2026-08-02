<?php

namespace App\Controller\Admin;

use App\Entity\RendezVous;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class RendezVousCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RendezVous::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),

            AssociationField::new('user', 'Client'),

            AssociationField::new('prestation'),

            DateTimeField::new('dateHeure', 'Date et heure'),

            ChoiceField::new('statut')
                ->setChoices([
                    'En attente' => 'EN_ATTENTE',
                    'Confirmé' => 'CONFIRME',
                    'Refusé' => 'REFUSE',
                    'Annulé' => 'ANNULE',
                ]),
        ];
    }

public function configureActions(Actions $actions): Actions
{
    $confirmer = Action::new('confirmer', 'Confirmer')
    ->setIcon('fa fa-check')
    ->displayIf(function (RendezVous $rendezVous) {
        return $rendezVous->getStatut() !== 'CONFIRME';
    })
    ->linkToRoute(
        'app_admin_rendez_vous_confirmer',
        function (RendezVous $rendezVous) {
            return [
                'id' => $rendezVous->getId(),
            ];
        }
    );

    $refuser = Action::new('refuser', 'Refuser')
    ->setIcon('fa fa-times')
    ->displayIf(function (RendezVous $rendezVous) {
        return $rendezVous->getStatut() !== 'REFUSE';
    })
    ->linkToRoute(
        'app_admin_rendez_vous_refuser',
        function (RendezVous $rendezVous) {
            return [
                'id' => $rendezVous->getId(),
            ];
        }
    );

    return $actions
        ->disable(Action::NEW, Action::DELETE)
        ->add(Crud::PAGE_INDEX, $confirmer)
        ->add(Crud::PAGE_INDEX, $refuser);
}
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort([
                'dateHeure' => 'ASC',
            ]);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('user'))
            ->add(EntityFilter::new('prestation'))
            ->add(DateTimeFilter::new('dateHeure'))
            ->add(
                ChoiceFilter::new('statut')
                    ->setChoices([
                        'En attente' => 'EN_ATTENTE',
                        'Confirmé' => 'CONFIRME',
                        'Refusé' => 'REFUSE',
                        'Annulé' => 'ANNULE',
                    ])
            );
    }
    
}