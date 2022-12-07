<?php

namespace App\Controller\Admin;

use App\Entity\TypeEvenement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypeEvenementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeEvenement::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
