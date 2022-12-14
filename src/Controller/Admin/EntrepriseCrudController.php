<?php

namespace App\Controller\Admin;

use App\Entity\Entreprise;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EntrepriseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Entreprise::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('NomEnt','Nom entreprise')->hideOnForm(),
            TextField::new('NomRef','Nom du referent')->hideOnForm(),
            TelephoneField::new('TelEnt','Telephone')->hideOnForm(),
            BooleanField::new('isDisabled','Compte désactivé')
        ];
    }
   public function configureActions(Actions $actions): Actions
   {
       return $actions
           // ...
           // this will forbid to create or delete entities in the backend
           ->disable(Action::NEW);
   }
}
