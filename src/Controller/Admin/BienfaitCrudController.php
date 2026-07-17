<?php

namespace App\Controller\Admin;

use App\Entity\Bienfait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BienfaitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bienfait::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),

            TextField::new('titre'),

            TextEditorField::new('description'),

            TextField::new('icone'),

            AssociationField::new('prestation'),
        ];
    }
}