<?php

namespace App\Controller;

use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\StageRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security("is_granted('ROLE_ETUDIANT') or is_granted('ROLE_ENSEIGNANT')")]
class StageController extends AbstractController
{
    #[Route('/stage', name: 'app_stage')]
    public function index(StageRepository $stageRepository, EtudiantRepository $etudiantRepository, EnseignantRepository $enseignantRepository): Response
    {
        $user=$this->getUser();
        $etudiant=$etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $enseignant=$enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);

        $stages = $stageRepository->findBy([], ['titreStage'=> 'ASC']);

        return $this->render('stage/index.html.twig', [
            'stages' => $stages,
            'user' => $user,
            'etudiant' => $etudiant,
            'enseignant' => $enseignant
        ]);
    }
}