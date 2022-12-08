<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use App\Factory\UtilisateurFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EtudiantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Etudiant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('numEtud')->setLabel('Numero'),
            TextField::new('nomEtud')->setLabel('Nom'),
            TextField::new('pnomEtud')->setLabel('Prénom'),
            DateField::new('dtnsEtud')->setLabel('Date de naissance'),
            TextField::new('adEtud')->setLabel("Adresse"),
            TextField::new('cpEtud')->setLabel("Code postal"),
            TextField::new('villeEtud')->setLabel('Ville'),
            AssociationField::new('cdUtil')->setFormTypeOptions(['choice_label'=>'login','query_builder'=>function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')->orderBy('c.login', 'ASC');
            }])->formatValue(function ($value, $entity) {
                return $entity->getCdUtil()->getLogin();
            })->setLabel('login')->hideOnForm(),
        ];
    }
}
