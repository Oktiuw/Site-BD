<?php

namespace App\Controller;

use App\Entity\SujetTER;
use App\Form\SujetTERType;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\SujetTERRepository;
use Doctrine\Persistence\ManagerRegistry;
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
            'user' => $user,
            'etudiant' => $etudiant,
            'enseignant' => $enseignant
        ]);
    }

    #[Route('/sujetter/create')]
    #[IsGranted('ROLE_ENSEIGNANT')]
    public function create(ManagerRegistry $doctrine, Request $request, EnseignantRepository $enseignantRepository)
    {
        $sujetTER = new SujetTER();
        $sujetTER->setEnseignant($enseignantRepository->findOneBy(['cdUtil'=>$this->getUser()->getId()]));

        $form = $this->createForm(SujetTERType::class, $sujetTER);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->persist($sujetTER);
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_sujet_ter');
        }

        return $this->renderForm('sujet_ter/create.html.twig', [
            'sujetTER' => $sujetTER,
            'form' => $form,
        ]);
    }

    #[Route('/sujetter/{id}/update', requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_ENSEIGNANT')]
    public function update(ManagerRegistry $doctrine, SujetTER $sujetTER, Request $request)
    {
        $form = $this->createForm(SujetTERType::class, $sujetTER);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            return $this->redirectToRoute('app_sujet_ter');
        }

        return $this->renderForm('sujet_ter/update.html.twig', [
            'sujetTER' => $sujetTER,
            'form' => $form,
        ]);
    }

    #[Route('/sujetter/{id}/delete', name: 'sujetter_delete', requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_ENSEIGNANT')]
    public function delete(ManagerRegistry $doctrine, SujetTER $sujetTER)
    {
        $doctrine->getManager()->remove($sujetTER);
        $doctrine->getManager()->flush();

        return $this->redirectToRoute('app_sujet_ter');
    }

    #[Route('/sujetter/{id}/register', name: 'sujetter_register', requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_ETUDIANT')]
    public function register(ManagerRegistry $doctrine, EtudiantRepository $etudiantRepository, SujetTER $sujetTER)
    {
        $sujetTER->setEtudiant($etudiantRepository->findOneBy(['cdUtil'=>$this->getUser()->getId()]));
        $doctrine->getManager()->persist($sujetTER);
        $doctrine->getManager()->flush();

        return $this->redirectToRoute('app_sujet_ter');
    }

    #[Route('/sujetter/{id}/unregister', name: 'sujetter_unregister', requirements: ['id'=>'\d+'])]
    #[IsGranted('ROLE_ETUDIANT')]
    public function unregister(ManagerRegistry $doctrine, EtudiantRepository $etudiantRepository, SujetTER $sujetTER)
    {
        $sujetTER->setEtudiant(null);
        $doctrine->getManager()->persist($sujetTER);
        $doctrine->getManager()->flush();

        return $this->redirectToRoute('app_sujet_ter');
    }
}
