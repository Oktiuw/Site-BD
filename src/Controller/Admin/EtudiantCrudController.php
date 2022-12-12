<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use App\Entity\Utilisateur;
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
            AssociationField::new('cdUtil')->formatValue(function ($value, $entity) {
                return $entity->getCdUtil()->getLogin();
            })->setLabel('login')->hideOnForm(),
        ];
    }
    /**
     * @param $entityInstance
     * @return void
     */
    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUser($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->setUser($entityInstance);
        parent::persistEntity($entityManager, $entityInstance); // TODO: Change the autogenerated stub
    }

    public function setUser($entityInstance): void
    {
        $lastname = $_POST['Enseignant']['nomEn'];
        $login = strtolower(str_replace(" ", "", "$lastname" . rand(1, 300)));
        $user = new Utilisateur();
        $user->setLogin($login);
        $user->setEmail('default@example.com');
        $user->setRoles(['ROLE_ETUDIANT']);
        $user->setPassword('test');
        $entityInstance->setCdUtil($user);
    }
}
