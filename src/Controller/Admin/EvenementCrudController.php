<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use App\Entity\Evenement;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class EvenementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Evenement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TimeField::new('hDeb')->renderAsChoice()->setLabel("Horaire de début"),
            TimeField::new('hFin')->setLabel("Horaire de fin")->renderAsChoice(),
            DateField::new('dateEvmt')->setLabel("Date de l'evenement"),
            AssociationField::new('TypeEvenement')->setFormTypeOptions(['choice_label'=>'intTpEvmt','query_builder'=>function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')->orderBy('c.intTpEvmt', 'ASC');
            }])->formatValue(function ($value, $entity) {
                return $entity->getTypeEvenement()->getIntTpEvmt();
            }),
            AssociationField::new('Enseignant')->setFormTypeOptions(['choice_label'=>function (Enseignant $enseignant) {
                return strtoupper($enseignant->getNomEn()).' '.$enseignant->getPnomEn();
            },'query_builder'=>function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')->orderBy('c.nomEn', 'ASC');
            }])->formatValue(function ($value, $entity) {
                return $entity->getEnseignant()->getNomEn();
            }),

        ];
    }
}
