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
        $avatar=null;
        if ($user->getAvatar() !== null) {
            $avatar=$user->setAvatar(base64_encode(stream_get_contents($user->getAvatar())));
        }
        return $this->render('entreprise/index.html.twig', [
            'user' =>$user,'profile'=>$profile,'avatar'=>$avatar
        ]);
    }
    #[Route('/entreprise/update')]
    public function update(EntrepriseRepository $entrepriseRepository, ManagerRegistry $doctrine, Request $request): Response
    {
        $userType=new UtilisateurType();
        $entrepriseType=new EntrepriseType();
        $user=$this->getUser();
        $avatar=null;
        if ($user->getAvatar() !== null) {
            $avatar=$user->setAvatar(base64_encode(stream_get_contents($user->getAvatar())));
        }
        $formUser=$this->createForm(UtilisateurType::class, $user)->add(
            'submit',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $entreprise=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $form=$this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        $formUser->handleRequest($request);
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            $entrepriseType=$form->getData();
            $userType=$formUser->getData();
            $entityManager=$doctrine->getManager();
            $entreprise->setNomEnt($entrepriseType->getNomEnt());
            $entreprise->setNomRef($entrepriseType->getNomRef());
            $user->setLogin($userType->getLogin());
            $user->setEmail($userType->getEmail());
            $entityManager->flush();
            return $this->redirectToRoute('app_entreprise');
        }
        return $this->renderForm('entreprise/update.html.twig', ['form'=>$form,'profile'=>$entreprise,'formUser'=>$formUser,'avatar'=>$avatar]);
    }
}
