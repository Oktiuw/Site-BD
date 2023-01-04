<?php

namespace App\Controller;

use App\Repository\CandidaturesRepository;
use App\Entity\Candidatures;
use App\Repository\EtudiantRepository;
use App\Repository\StageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatureController extends AbstractController
{
    #[Route('/candidature', name: 'app_candidature_create')]
    #[IsGranted('ROLE_ETUDIANT')]
    public function create(
        ManagerRegistry $doctrine,
        Request $request,
        StageRepository $stageRepository,
        EtudiantRepository $etudiantRepository,
        CandidaturesRepository $canditaturesRepository
    ) {
        $stage = $stageRepository->findOneBy(['id'=>$request->get('id')]);
        $etudiant = $etudiantRepository->findOneBy(['cdUtil'=>$this->getUser()->getId()]);
        if ($stage->getNiveau() === $etudiant->getNiveau()
            and $canditaturesRepository->findOneBy(['stage'=>$stage, 'etudiant'=>$etudiant])==null) {
            $candidature = new Candidatures();
            $candidature->setEtudiant($etudiant);
            $candidature->setStage($stage);

            $doctrine->getManager()->persist($candidature);
            $doctrine->getManager()->flush();
        }
        return $this->redirectToRoute('app_stage');
    }

    #[Route('/candidature/{id}', name: 'app_candidature')]
    #[IsGranted('ROLE_ENTREPRISE')]
    public function index($id, StageRepository $stageRepository): Response
    {
        $stage = $stageRepository->findOneBy(['id'=>$id]);
        $candidatures = $stage->getCandidatures();
        $user = $this->getUser();

        if ($stage->getEntreprise()->getCdUtil()->getId() != $user->getId()) {
            return $this->redirectToRoute('app_stage');
        }

        return $this->render('candidature/index.html.twig', [
            'canditatures' => $candidatures,
            'stage' => $stage,
            'user' => $user,
        ]);
    }
}
