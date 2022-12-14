<?php

namespace App\Controller\Admin;

use App\Entity\Enseignant;
use App\Entity\Entreprise;
use App\Entity\Etudiant;
use App\Entity\Evenement;
use App\Entity\GroupeEtudiants;
use App\Entity\Niveau;
use App\Entity\TypeEvenement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration')->setLocales(['fr']);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Niveau', "fa-solid fa-book", Niveau::class);
        yield MenuItem::linkToCrud('Evenement', "fa-solid fa-calendar-days", Evenement::class);
        yield MenuItem::linkToCrud('Type evenement', "fa-solid fa-font-awesome", TypeEvenement::class);
        yield MenuItem::linkToCrud('Etudiant', "fa-solid fa-user", Etudiant::class);
        yield MenuItem::linkToCrud('Enseignant', "fa-solid fa-graduation-cap", Enseignant::class);
        yield MenuItem::linkToCrud('Entreprise', "fa-solid fa-building", Entreprise::class);
        yield MenuItem::linkToCrud('Groupe etudiants', "fa-solid fa-people-group", GroupeEtudiants::class);
        yield MenuItem::linkToRoute("Retour à l'accueil", 'fa fa-home','app_home');
    }
    public function configureAssets(): Assets
    {
        return parent::configureAssets()->addCssFile('https://fonts.googleapis.com/icon?family=Material+Icons');
    }
}
