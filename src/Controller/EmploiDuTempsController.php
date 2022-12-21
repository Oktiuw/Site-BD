<?php

namespace App\Controller;

use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security("is_granted('ROLE_ETUDIANT') or is_granted('ROLE_ENSEIGNANT')")]
class EmploiDuTempsController extends AbstractController
{
    #[Route('/emploi_du_temps', name: 'app_emploi_du_temps')]
    public function index(): Response
    {
        $currentDate= new \DateTime();
        return $this->render('emploi_du_temps/index.html.twig', [
            'date' =>$currentDate->format('Y-m-d H:i:s')
        ]);
    }
    public function getTypeUser(EtudiantRepository $etudiantRepository, EnseignantRepository $enseignantRepository): \App\Entity\Etudiant|\App\Entity\Enseignant|null
    {
        $user=$this->getUser();
        if ($user->getRoles()[0]=="ROLE_ETUDIANT") {
            return $etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        }
        return $enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);
    }
}
