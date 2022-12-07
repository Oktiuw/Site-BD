<?php

namespace App\Controller\Admin;

use App\Entity\GroupeEtudiants;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GroupeEtudiantsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GroupeEtudiants::class;
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
