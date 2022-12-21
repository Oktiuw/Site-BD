<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security("is_granted('ROLE_ETUDIANT') or is_granted('ROLE_ENSEIGNANT')")]
class EmploiDuTempsController extends AbstractController
{
    #[Route('/emploidutemps', name: 'app_emploi_du_temps')]
    public function index(EtudiantRepository $etudiantRepository, EnseignantRepository $enseignantRepository, $currentDate=null): Response
    {
        if ($currentDate===null) {
            $currentDate= new \DateTime();
            $currentDate->setTimezone(new \DateTimeZone('Europe/Paris'));
        }
        $user=$this->getTypeUser($etudiantRepository, $enseignantRepository);
        if ($user instanceof (Enseignant::class)) {
            $evenements=$user->getEvenements();
        } else {
            $groupesEtudiants=$user->getGroupeEtudiants();
            $evenements=[];
            foreach ($groupesEtudiants as $groupeEtudiants) {
                $evenements+=$groupeEtudiants->getEvenements()->toArray();
            }
        }
        $cours=[];
        foreach ($evenements as $evenement) {
            if ($evenement->getDateEvmt()->format('d/m/Y')==$currentDate->format('d/m/Y')) {
                $cours[]=$evenement;
            }
        }
        uasort($cours, function ($a, $b): int {
            if ($a->getHDeb()==$b->getHDeb()) {
                return 0;
            }
            return ($a->getHDeb()<$b->getHDeb() ? -1 : 1);
        });
        return $this->render('emploi_du_temps/index.html.twig', [
            'date' =>$currentDate->format('d/m/Y'),'cours'=>$cours,'user'=>$this->getUser()
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
