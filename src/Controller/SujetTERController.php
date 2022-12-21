<?php

namespace App\Controller;

use App\Entity\SujetTER;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\SujetTERRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

#[Security("is_granted('ROLE_ETUDIANT') or is_granted('ROLE_ENSEIGNANT')")]
class SujetTERController extends AbstractController
{
    #[Route('/sujetter', name: 'app_sujet_ter')]
    public function index(SujetTERRepository $sujetTERRepository, EtudiantRepository $etudiantRepository, EnseignantRepository $enseignantRepository): Response
    {
        $user=$this->getUser();
        $etudiant=$etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $enseignant=$enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);

        $sujetsTER = $sujetTERRepository->findBy([], ['titreTer'=> 'ASC']);

        return $this->render('sujet_ter/index.html.twig', [
            'sujetsTER' => $sujetsTER,
            'etudiant' => $etudiant,
            'enseignant' => $enseignant
        ]);
    }

    #[Route('/sujetter/create')]
    public function create()
    {

    }
    #[Route('/sujetter/{id}/update', requirements: ['id'=>'\d+'])]
    public function update(ManagerRegistry $doctrine, SujetTER $sujetTER, Request $request)
    {

    }

    #[Route('/sujetter/{id}/delete')]
    public function delete()
    {

    }

}
