<?php

namespace App\Controller;

use App\Entity\SujetTER;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\SujetTERRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Security("is_granted('ROLE_ETUDIANT') or is_granted('ROLE_ENSEIGNANT')")]
class SujetTERController extends AbstractController
{
    #[Route('/sujetter', name: 'app_sujet_ter')]
    #[IsGranted('ROLE_ETUDIANT')]
    public function indexEtudiant(SujetTERRepository $sujetTERRepository, EtudiantRepository $etudiantRepository): Response
    {
        $user=$this->getUser();
        $etudiant=$etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);

        $sujetsTER = $sujetTERRepository->findBy([], ['titreTer'=> 'ASC']);
        return $this->render('sujet_ter/index.html.twig', [
            'sujetsTER' => $sujetsTER,
            'user' => $etudiant
        ]);
    }


    #[Route('/sujetter', name: 'app_sujet_ter')]
    #[IsGranted('ROLE_ENSEIGNANT')]
    public function indexEnseignant(SujetTERRepository $sujetTERRepository, EnseignantRepository $enseignantRepository): Response
    {
        $user=$this->getUser();
        $enseignant=$enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);

        $sujetsTER = $sujetTERRepository->findBy([], ['titreTer'=> 'ASC']);
        return $this->render('sujet_ter/index.html.twig', [
            'sujetsTER' => $sujetsTER,
            'user' => $enseignant
        ]);
    }
}
