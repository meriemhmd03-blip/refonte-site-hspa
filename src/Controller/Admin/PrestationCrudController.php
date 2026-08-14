<?php

namespace App\Controller\Admin;

use App\Entity\Prestation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class PrestationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Prestation::class;
    }

    public function configureFields(string $pageName): iterable
{
    return [

        IdField::new('id')
            ->hideOnForm(),

        NumberField::new('prix')
    ->setLabel('Prix (€)'),

        TextField::new('nom'),

        TextField::new('slug'),

        IntegerField::new('duree')
            ->setLabel('Durée (minutes)'),

        TextField::new('heroImage'),

        TextField::new('imageTechnique'),

        TextField::new('imageResultats'),

        TextEditorField::new('heroSousTitre'),

        TextEditorField::new('heroDescription'),

        TextEditorField::new('introduction'),

        TextEditorField::new('technique'),

        TextEditorField::new('resultats'),

    ];
}
}