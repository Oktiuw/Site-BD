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
            AssociationField::new('niveau')->setRequired(false)->formatValue(function ($value, $entity) {
                return ($entity->getNiveau()) ? $entity->getNiveau()->getLibNiv() : "Pas de niveau";
            })->setFormTypeOptions(['choice_label'=>'LibNiv', 'query_builder'=>function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')->orderBy('c.libNiv', 'ASC');
            }]),
            AssociationField::new('etudiants')
                ->setFormTypeOptions(['choice_label'=>function ($entity) {
                    return strtoupper($entity->getNomEtud()).  " {$entity->getPnomEtud()}";
                }])->formatValue(function ($value, $entity) {
                    $res="";
                    $compteur=0;
                    foreach ($entity->getEtudiants() as $etudiant) {
                        $compteur+=1;
                        $lastname=strtoupper($etudiant->getNomEtud());
                        $res .= " {$lastname} {$etudiant->getPnomEtud()}";
                        if ($compteur>4) {
                            $compteur=0;
                            $res.=nl2br("\n");
                        }
                    }
                    return $res;
                }),
        ];
    }
}
