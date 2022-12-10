<?php

namespace App\Controller;

use App\Form\EnseignantType;
use App\Form\UtilisateurType;
use App\Repository\EnseignantRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
class EnseignantController extends AbstractController
{
    #[Route('/enseignant', name: 'app_enseignant')]
    public function index(EnseignantRepository $enseignantRepository): Response
    {
        $user=$this->getUser();
        $profile=$enseignantRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $avatar=null;
        if ($user->getAvatar() !== null) {
            $avatar=$user->setAvatar(base64_encode(stream_get_contents($user->getAvatar())));
        }
        return $this->render('enseignant/index.html.twig', [
            'user' =>$user,'profile'=>$profile,'avatar'=>$avatar
        ]);
    }
    #[Route('/enseignant/update')]
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
        return $this->renderForm('enseignant/update', ['form'=>$form,'profile'=>$enseignant,'user'=>$user,'formUser'=>$formUser]);
    }
}





