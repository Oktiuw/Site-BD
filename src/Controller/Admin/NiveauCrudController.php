<?php

namespace App\Controller\Admin;

use App\Entity\Niveau;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NiveauCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Niveau::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('LibNiv')->setLabel("Nom niveau"),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::DELETE,Action::EDIT);
    }
}
