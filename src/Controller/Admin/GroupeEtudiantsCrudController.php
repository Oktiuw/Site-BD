<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use App\Entity\GroupeEtudiants;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GroupeEtudiantsCrudController extends AbstractCrudController
{
    protected EtudiantRepository $etudiantRepository;
    public function __construct(EtudiantRepository $etudiantRepository)
    {
        $this->etudiantRepository=$etudiantRepository;
    }
    public static function getEntityFqcn(): string
    {
        return GroupeEtudiants::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nomGroupe'),
            AssociationField::new('etudiants')->formatValue(function ($value, $entity) {
                $res="";
                $compteur=0;
                foreach ($entity->getEtudiants() as $etudiant) {
                    $res .="{$etudiant->getNomEtud()} {$etudiant->getPnomEtud()}/";
                    $compteur+=1;
                    if ($compteur>4) {
                        $res.=nl2br("\n");
                        $compteur=0;
                    }
                }
                return $res;
            })->setFormTypeOptions(['choice_label'=>function (Etudiant $etudiant) {
                return strtoupper($etudiant->getNomEtud()).' '.$etudiant->getPnomEtud();
            },'query_builder'=>function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')->orderBy('c.nomEtud,c.pnomEtud', 'ASC');
            }]),
            AssociationField::new('niveau')->formatValue(function ($value, $entity) {
                return $entity->getNiveau()->getLibNiv();
            })->setFormTypeOptions(['choice_label'=>'LibNiv', 'query_builder'=>function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')->orderBy('c.libNiv', 'ASC');
            }]),
        ];
    }
}
