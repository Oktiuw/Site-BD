<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class EmploiDuTempsController extends AbstractController
{
    #[Route('/emploidutemps', name: 'app_emploi_du_temps')]
    public function index(): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $date=new \DateTime();
        return $this->redirectToRoute("app_emploi_du_temps_date", ['currentDate'=>$date->format('d-m-y')]);
    }
    #[Route('/emploidutemps/{currentDate}', name: 'app_emploi_du_temps_date')]
    public function edtdate(EtudiantRepository $etudiantRepository, EnseignantRepository $enseignantRepository, $currentDate): Response
    {
        $date=\DateTime::createFromFormat('d-m-y', $currentDate);
        $beforeDate=\DateTime::createFromFormat('d-m-y', $currentDate);
        $afterDate=\DateTime::createFromFormat('d-m-y', $currentDate);
        $beforeDate->modify("-1 day");
        $afterDate->modify("+1 day");
        $nextWeek=\DateTime::createFromFormat('d-m-y', $currentDate)->modify("+7 day");
        $previousWeek=\DateTime::createFromFormat('d-m-y', $currentDate)->modify("-7 day");
        if ($date===false) {
            return $this->redirectToRoute('app_emploi_du_temps');
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
            if ($evenement->getDateEvmt()->format('d/m/Y')==$date->format('d/m/Y')) {
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
            'date' =>$date,'cours'=>$cours,'user'=>$this->getUser(),'beforeDate'=>$beforeDate,'afterDate'=>$afterDate,'nextWeek'=>$nextWeek,'previousWeek'=>$previousWeek
        ]);
    }
    public function getTypeUser(EtudiantRepository $etudiantRepository, EnseignantRepository $enseignantRepository): \Symfony\Component\HttpFoundation\RedirectResponse|\App\Entity\Etudiant|Enseignant|null
    {
        $user=$this->getUser();
        if ($user->getRoles()[0]=="ROLE_ETUDIANT") {
            return $etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        }
        if ($user->getRoles()[0]=="ROLE_ENTREPRISE") {
            return $this->redirectToRoute('app_redirecteur');
        }
        return $enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);
    }
    #[Security("is_granted('ROLE_ENSEIGNANT') or is_granted('ROLE_ADMIN,ROLE_ENSEIGNANT')")]
    #[Route('/emploidutemps/{id}/update', name: 'app_emploi_du_temps_update')]
    public function updateEvmt(Request $request, Evenement $evenement, ManagerRegistry $doctrine): Response
    {
        $form=$this->createForm(EvenementType::class, $evenement)->add('submit', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_emploi_du_temps');
        }
        return $this->renderForm('emploi_du_temps/update.html.twig', ['form'=>$form]);
    }
}
