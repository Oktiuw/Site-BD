<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\EnseignantRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\StageRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security("is_granted('IS_AUTHENTICATED_FULLY')")]
class StageController extends AbstractController
{
    #[Route('/stage', name: 'app_stage')]
    public function index(StageRepository $stageRepository, EtudiantRepository $etudiantRepository, EnseignantRepository $enseignantRepository, EntrepriseRepository $entrepriseRepository): Response
    {
        $user=$this->getUser();
        $etudiant=$etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $enseignant=$enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $entreprise=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);

        if ($etudiant || $enseignant) {
            $stages = $stageRepository->findBy([], ['titreStage'=> 'ASC']);
        } else {
            if ($this->isAccountDisabled($entrepriseRepository)) {
                return $this->redirectToRoute('app_redirecteur');
            }
            $stages = $stageRepository->findBy(['entreprise' => $entreprise], ['titreStage'=> 'ASC']);
        }

        return $this->render('stage/index.html.twig', [
            'stages' => $stages,
            'user' => $user,
            'etudiant' => $etudiant,
            'entreprise' => $entreprise
        ]);
    }

    #[Route('/stage/create')]
    #[IsGranted('ROLE_ENTREPRISE')]
    public function create(ManagerRegistry $doctrine, Request $request, EntrepriseRepository $entrepriseRepository)
    {
        if ($this->isAccountDisabled($entrepriseRepository)) {
            return $this->redirectToRoute('app_redirecteur');
        }
        $stage = new Stage();
        $stage->setEntreprise($entrepriseRepository->findOneBy(['cdUtil'=>$this->getUser()->getId()]));

        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->persist($stage);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_stage');
        }

        return $this->renderForm('stage/create.html.twig', [
            'stage' => $stage,
            'form' => $form,
        ]);
    }

    #[Route('/stage/{id}/update', requirements: ['id' => '\d+'])]
    #[IsGranted('ROLE_ENTREPRISE')]
    public function update(Stage $stage, Request $request, ManagerRegistry $doctrine, EntrepriseRepository $entrepriseRepository)
    {
        if ($this->isAccountDisabled($entrepriseRepository)) {
            return $this->redirectToRoute('app_redirecteur');
        }
        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_stage');
        }

        return $this->renderForm('stage/update.html.twig', [
            'stage' => $stage,
            'form' => $form,
        ]);
    }

    #[Route('/stage/{id}/delete', name: 'stage_delete', requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_ENTREPRISE')]
    public function delete(ManagerRegistry $doctrine, Stage $stage)
    {
        $doctrine->getManager()->remove($stage);
        $doctrine->getManager()->flush();

        return $this->redirectToRoute('app_stage');
    }
    public function isAccountDisabled(EntrepriseRepository $entrepriseRepository): bool
    {
        $user=$this->getUser();
        if ($user->getRoles()[0]==='ROLE_ENTREPRISE') {
            $entreprise=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
            if ($entreprise->isIsdisabled()) {
                return true;
            }
        }
        return false;
    }
}
