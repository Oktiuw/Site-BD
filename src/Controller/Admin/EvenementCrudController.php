<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use App\Entity\Evenement;
use App\Repository\EnseignantRepository;
use App\Repository\GroupeEtudiantsRepository;
use App\Repository\TypeEvenementRepository;
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
    private GroupeEtudiantsRepository $groupeEtudiantsRepository;
    private TypeEvenementRepository $typeEvenementRepository;
    private EnseignantRepository $enseignantRepository;
    public function __construct(GroupeEtudiantsRepository $groupeEtudiantsRepository, TypeEvenementRepository $typeEvenementRepository, EnseignantRepository $enseignantRepository)
    {
        $this->groupeEtudiantsRepository=$groupeEtudiantsRepository;
        $this->typeEvenementRepository=$typeEvenementRepository;
        $this->enseignantRepository=$enseignantRepository;
    }
    public static function getEntityFqcn(): string
    {
        return Evenement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TimeField::new('hDeb')->renderAsChoice()->setLabel("Horaire de début")->setFormat('HH:mm')->setTimezone('Europe/Paris'),
            TimeField::new('hFin')->setLabel("Horaire de fin")->setFormat('HH:mm')->renderAsChoice()->setTimezone('Europe/Paris'),
            DateField::new('dateEvmt')->setLabel("Date de l'evenement")->setTimezone('Europe/Paris'),
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
            })->setRequired(true),
            IntegerField::new('etreEtale')->setLabel('Nombre de semaine')->hideOnIndex()->hideOnDetail()->setRequired(true)

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
        $this->reccurenceSemaines($entityManager);
    }

    /**
     * @throws \Exception
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->reccurenceSemaines($entityManager);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function reccurenceSemaines(EntityManagerInterface $entityManager): void
    {
        $semaines = $_POST['Evenement']['etreEtale'];
        if ($semaines <= 0) {
            $semaines = 1;
        }
        $groupeEtudiants=$_POST['Evenement']['groupeEtudiants'];
        $res=[];
        foreach ($groupeEtudiants as $groupeEtudiant) {
            $res[]=$this->groupeEtudiantsRepository->find($groupeEtudiant);
        }
        for ($i = 0; $i < $semaines; $i++) {
            $evenement = new Evenement();
            $evenement->addGroupesEtudiants($res);
            $jours=$i*7;
            $date=$_POST['Evenement']['dateEvmt'];
            $jours='P'.$jours.'D';
            $date=new DateTime($date);
            $date->add(new \DateInterval($jours));
            $evenement->setDateEvmt($date);
            $evenement->setTypeEvenement($this->typeEvenementRepository->find($_POST['Evenement']['TypeEvenement']));
            $evenement->setEnseignant($this->enseignantRepository->find($_POST['Evenement']['Enseignant']));
            $hdeb = new DateTime($evenement->getDateEvmt()->format('y-m-d'));
            $hdeb->setTime($_POST['Evenement']['hDeb']['hour'], $_POST['Evenement']['hDeb']['minute']);
            $hfin=new DateTime($evenement->getDateEvmt()->format('y-m-d'));
            $hfin->setTime($_POST['Evenement']['hFin']['hour'], $_POST['Evenement']['hDeb']['minute']);
            $evenement->setHDeb($hdeb);
            $evenement->setHFin($hfin);
            $entityManager->persist($evenement);
        }
        $entityManager->flush();
    }
}
