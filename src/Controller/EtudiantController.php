<?php

namespace App\Controller;

use App\Form\EntrepriseType;
use App\Form\EtudiantType;
use App\Form\UtilisateurType;
use App\Repository\EntrepriseRepository;
use App\Repository\EtudiantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[IsGranted('ROLE_ETUDIANT')]
class EtudiantController extends AbstractController
{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(EtudiantRepository $etudiantRepository, ManagerRegistry $doctrine): Response
    {
        $user=$this->getUser();
        $profile=$etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $avatar=$user->getAvatar();
        $script="";
        if ($profile->isFirstConnection()) {
            $profile->setFirstConnection(false);
            $script='Première connexion détectée ! Modifiez votre mail et votre mot de passe par défaut! ';
            $doctrine->getManager()->flush();
        }
        return $this->render('etudiant/index.html.twig', [
            'user' =>$user,'profile'=>$profile,'avatar'=>$avatar,'script'=>$script
        ]);
    }

    #[Route('/etudiant/update')]
    public function update(SluggerInterface $slug, EtudiantRepository $etudiantRepository, ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user=$this->getUser();
        $avatar = $user->getAvatar();
        $etudiant=$etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $formUser=$this->createForm(UtilisateurType::class, $user);
        $form=$this->createForm(EtudiantType::class, $etudiant)->add(
            'submit',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        ;
        $form->handleRequest($request);
        $formUser->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $etudiantType=$form->getData();
            $userData=$formUser->getData();
            $entityManager=$doctrine->getManager();
            $etudiant->setNomEtud($etudiantType->getNomEtud());
            $etudiant->getCdUtil()->setEmail($userData->getEmail());
            $cv = $form->get("CV")->getData();

            if ($cv) {
                $originalName = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFileName = $slug->slug($originalName);
                $newFile = $safeFileName."-".uniqid()."-".$cv->guessExtension();
                try {
                    $cv->move($this->getParameter("pdfs_directory"), $newFile);
                } catch (FileException $e) {
                }
                $AncienPdf = $etudiant->getCvEtud();
                if ($AncienPdf) {
                    unlink("img/usersCV/$AncienPdf");
                }
                $etudiant->setCvEtud($newFile);
            }
            $entityManager->persist($etudiant);
            $entityManager->flush();
            return $this->redirectToRoute('app_redirecteur');
        }
        return $this->renderForm('etudiant/update.html.twig', ['profile'=>$etudiant,'form'=>$form,'avatar'=>$avatar, 'formUser'=>$formUser]);
    }
}
