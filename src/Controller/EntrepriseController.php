<?php

namespace App\Controller;

use App\Form\EntrepriseType;
use App\Form\UtilisateurType;
use App\Repository\EntrepriseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ENTREPRISE')]
class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        $user=$this->getUser();
        $profile=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
        return $this->render('entreprise/index.html.twig', [
            'user' =>$user,'profile'=>$profile]);
    }
    #[Route('/entreprise/update')]
    public function update(EntrepriseRepository $entrepriseRepository, ManagerRegistry $doctrine, Request $request): Response
    {
        $entrepriseType=new EntrepriseType();
        $user=$this->getUser();
        $entreprise=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $form=$this->createForm(EntrepriseType::class, $entreprise)->add(
            'submit',
            SubmitType::class,
            ['label' => 'Modifier']
        );;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entrepriseType=$form->getData();
            $entityManager=$doctrine->getManager();
            $entreprise->setNomEnt($entrepriseType->getNomEnt());
            $entreprise->setNomRef($entrepriseType->getNomRef());
            $entityManager->flush();
            return $this->redirectToRoute('app_entreprise');
        }
        return $this->renderForm('entreprise/update.html.twig', ['form'=>$form,'profile'=>$entreprise,'user'=>$user]);
    }
}
