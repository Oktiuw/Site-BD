<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EnseignantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Enseignant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
     TextField::new('numEn')->setLabel('Numero'),
     TextField::new('nomEn')->setLabel('Nom'),
     TextField::new('pnomEn')->setLabel('Prénom'),
            DateField::new('dtnsEn')->setLabel('Date de naissance'),
     TextField::new('adEn')->setLabel("Adresse"),
     TextField::new('cpEn')->setLabel("Code postal"),
     TextField::new('villeEn')->setLabel('Ville'),
     AssociationField::new('cdUtil')->setFormTypeOptions(['choice_label'=>'login','query_builder'=>function (EntityRepository $entityRepository) {
         return $entityRepository->createQueryBuilder('c')->orderBy('c.login', 'ASC');
     }])->formatValue(function ($value, $entity) {
         return $entity->getCdUtil()->getLogin();
     })->setLabel('login')->hideOnForm(),
 ];
    }
}
