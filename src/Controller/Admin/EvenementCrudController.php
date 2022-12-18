<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use App\Entity\Evenement;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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
            TimeField::new('hDeb')->renderAsChoice()->setLabel("Horaire de début")->setFormat('HH:mm'),
            TimeField::new('hFin')->setLabel("Horaire de fin")->setFormat('HH:mm')->renderAsChoice(),
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
            AssociationField::new('groupeEtudiants')->setFormTypeOptions(['choice_label'=>'nomGroupe','query_builder'=>function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('c')->orderBy('c.nomGroupe', 'ASC');
            }])->formatValue(function ($value, $entity) {
                $res="";
                foreach ($entity->getGroupeEtudiants() as $groupe) {
                    $res .= " | {$groupe->getNomGroupe()}";
                }
                return $res;
            }),
            IntegerField::new('etreEtale')->setLabel('Nombre de semaine')->hideOnIndex()->hideOnDetail()

        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            // this will forbid to create or delete entities in the backend
            ->disable(Action::EDIT);
    }

    /**
     * @throws \Exception
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->reccurenceSemaines();
        parent::updateEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }

    /**
     * @throws \Exception
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->reccurenceSemaines();
        parent::persistEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function reccurenceSemaines(): void
    {
        $semaines = $_POST['Evenement']['etreEtale'];
        if ($semaines <= 0) {
            $semaines = 1;
        }
        for ($i = 0; $i <= $semaines; $i++) {
            $evenement = new Evenement();
            $evenement->addGroupesEtudiants($_POST['Evenement']['groupeEtudiants']);
            $evenement->setDateEvmt($_POST['Evenement']['dateEvmt']);
            $evenement->setTypeEvenement($_POST['Evenement']['TypeEvenement']);
            $evenement->setEnseignant($_POST['Evenement']['Enseignant']);
            $hdeb = new DateTime($evenement->getDateEvmt());
            $hfin = new DateTime($evenement->getDateEvmt());
            $hdeb->setTime($_POST['Evenement']['hdeb']['hour'], $_POST['Evenement']['hdeb']['minute']);
            $hdeb->setTime($_POST['Evenement']['hfin']['hour'], $_POST['Evenement']['hfin']['minute']);
            $evenement->setHDeb($hdeb);
            $evenement->setHFin($hfin);
        }
    }
}
