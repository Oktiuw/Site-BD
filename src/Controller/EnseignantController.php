<?php

namespace App\Controller;

use App\Form\EnseignantType;
use App\Form\UtilisateurType;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\NiveauRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Security("is_granted('ROLE_ETUDIANT') or is_granted('ROLE_ENSEIGNANT') or is_granted('ROLE_ADMIN,ROLE_ENSEIGNANT')")]
class EnseignantController extends AbstractController
{
    #[Route('/enseignant', name: 'app_enseignant')]
    public function index(EnseignantRepository $enseignantRepository, ManagerRegistry $doctrine): Response
    {
        $user=$this->getUser();
        $profile=$enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $script="";
        if ($profile->isFirstConnection()) {
            $profile->setFirstConnection(false);
            $script='Première connexion détectée ! Modifiez votre mail et votre mot de passe par défaut! ';
            $doctrine->getManager()->flush();
        }
        return $this->render('enseignant/index.html.twig', [
            'user' =>$user,'profile'=>$profile,'avatar'=>$user->getAvatar(),'script'=>$script
        ]);
    }
    #[Route('/enseignant/update', name: 'app_enseignant_update')]
    public function update(EnseignantRepository $enseignantRepository, ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $enseignantType=new EnseignantType();
        $user=$this->getUser();
        $enseignant=$enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $formUser=$this->createForm(UtilisateurType::class, $user);

        $form=$this->createForm(EnseignantType::class, $enseignant)->add(
            'submit',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        $formUser->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $enseignantType=$form->getData();
            $userData=$formUser->getData();
            $entityManager=$doctrine->getManager();
            $enseignant->setNomEn($enseignantType->getNomEn());
            $enseignant->setPnomEn($enseignantType->getPnomEn());
            $enseignant->getCdUtil()->setEmail($userData->getEmail());
            $entityManager->flush();
            return $this->redirectToRoute('app_enseignant');
        }
        return $this->renderForm('enseignant/update.html.twig', ['form'=>$form,'profile'=>$enseignant,'user'=>$user,'formUser'=>$formUser]);
    }
    #[IsGranted("ROLE_ADMIN,ROLE_ENSEIGNANT")]
    #[Route('/enseignant/studentActions', name: 'app_enseignant_studentActions')]
    public function studentActions(): Response
    {
        return $this->render('enseignant/studentActions.html.twig', ['user'=>$this->getUser()]);
    }
    #[IsGranted("ROLE_ADMIN,ROLE_ENSEIGNANT")]
    #[Route('/enseignant/studentActions/m1tom2', name: 'app_enseignant_m1tom2')]
    public function m1toM2(NiveauRepository $niveauRepository): Response
    {
        $students=$niveauRepository->findOneBy(['libNiv'=>'M1'])->getEtudiants();
        return $this->render('enseignant/studentList.html.twig', ['user'=>$this->getUser(),'var'=>'Du M1 au M2','students'=>$students]);
    }
}
