<?php

namespace App\Controller;

use App\Entity\Canditatures;
use App\Repository\EtudiantRepository;
use App\Repository\StageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    #[Route('/candidature', name: 'app_candidature_create')]
    public function create(ManagerRegistry $doctrine, Request $request, StageRepository $stageRepository, EtudiantRepository $etudiantRepository)
    {
        $candidature = new Canditatures();
        $candidature->setEtudiant($etudiantRepository->findOneBy(['cdUtil'=>$this->getUser()->getId()]));
        $candidature->setStage($stageRepository->findOneBy(['id'=>$request->get('id')]));
        $candidature->setPj(file_get_contents('img/cvsae.pdf', true));
        #$etudiantRepository->findOneBy(['cdUtil'=>$this->getUser()->getId()])->getCvEtud());

        $doctrine->getManager()->persist($candidature);
        $doctrine->getManager()->flush();
        return $this->redirectToRoute('app_stage');
    }

    #on veut voir les candidatures d'un stage
    #[Route('/candidature/{id}', name: 'app_candidature')]
    public function index($id, StageRepository $stageRepository, EtudiantRepository $etudiantRepository): Response
    {
        $stage = $stageRepository->findOneBy(['id'=>$id]);
        $candidatures = $stage->getCanditatures();
        $user = $this->getUser();
        
        return $this->render('candidature/index.html.twig', [
            'canditatures' => $candidatures,
            'stage' => $stage,
            'user' => $user,
        ]);
    }


    
}
