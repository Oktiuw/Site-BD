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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ETUDIANT')]
class EtudiantController extends AbstractController

{
    #[Route('/etudiant', name: 'app_etudiant')]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        $user=$this->getUser();
        $profile=$etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $avatar=null;
        if ($user->getAvatar() !== null) {
            $avatar=$user->setAvatar(base64_encode(stream_get_contents($user->getAvatar())));
        }
        return $this->render('etudiant/index.html.twig', [
            'user' =>$user,'profile'=>$profile,'avatar'=>$avatar
        ]);
    }

    #[Route('/etudiant/update')]
    public function update(EtudiantRepository $etudiantRepository, ManagerRegistry $doctrine, Request $request): Response
    {
        $userType=new UtilisateurType();
        $etudiantType=new EtudiantType();
        $user=$this->getUser();
        $avatar=null;
        if ($user->getAvatar() !== null) {
            $avatar=$user->setAvatar(base64_encode(stream_get_contents($user->getAvatar())));
        }
        $etudiant=$etudiantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $form=$this->createForm(EtudiantType::class, $etudiant)->add(
            'submit',
            SubmitType::class,
            ['label' => 'Modifier']
        );;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $etudiantType=$form->getData();
            $entityManager=$doctrine->getManager();
            $etudiant->setNomEtud($etudiantType->getNomEtud());
            $entityManager->flush();
            return $this->redirectToRoute('app_etudiant');
        }
        return $this->renderForm('etudiant/update.html.twig', ['form'=>$form,'profile'=>$etudiant,'form'=>$form,'avatar'=>$avatar]);
    }

}





