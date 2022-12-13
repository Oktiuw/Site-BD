<?php

namespace App\Controller\Admin;

use App\Entity\TypeEvenement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeEvenementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeEvenement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('IntTpEvmt')->setLabel("Type d'évenement"),
        ];
    }
}
