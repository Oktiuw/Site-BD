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
            ->setTitle('Sae3 01');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Niveau',null,Niveau::class);
        yield MenuItem::linkToCrud('Evenement',null,Evenement::class);
        yield MenuItem::linkToCrud('TypeEvenement',null,TypeEvenement::class);
        yield MenuItem::linkToCrud('Etudiant',null,Etudiant::class);
        yield MenuItem::linkToCrud('Enseignant',null,Enseignant::class);
        yield MenuItem::linkToCrud('Entreprise',null,Entreprise::class);
        yield MenuItem::linkToCrud('GroupeEtudiants',null,GroupeEtudiants::class);
    }
    public function configureAssets(): Assets
    {
        return parent::configureAssets()->addCssFile('https://fonts.googleapis.com/icon?family=Material+Icons');
    }
}
