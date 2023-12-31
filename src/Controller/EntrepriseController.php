<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Utilisateur;
use App\Form\EntrepriseType;
use App\Form\UtilisateurType;
use App\Mail\EmailSender;
use App\Repository\EnseignantRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{
    #[IsGranted('ROLE_ENTREPRISE')]
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        $user=$this->getUser();
        $profile=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
        return $this->render('entreprise/index.html.twig', [
            'user' =>$user,'profile'=>$profile]);
    }
    #[IsGranted('ROLE_ENTREPRISE')]
    #[Route('/entreprise/update')]
    public function update(EntrepriseRepository $entrepriseRepository, ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user=$this->getUser();
        $entreprise=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $formUser=$this->createForm(UtilisateurType::class, $user);

        $form=$this->createForm(EntrepriseType::class, $entreprise)->add(
            'submit',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        $formUser->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entrepriseType=$form->getData();
            $userData=$formUser->getData();
            $entityManager=$doctrine->getManager();
            $entreprise->setNomEnt($entrepriseType->getNomEnt());
            $entreprise->setNomRef($entrepriseType->getNomRef());
            $entreprise->getCdUtil()->setEmail($userData->getEmail());
            $entityManager->flush();
            return $this->redirectToRoute('app_redirecteur');
        }
        return $this->renderForm('entreprise/update.html.twig', ['form'=>$form,'profile'=>$entreprise,'user'=>$user,'formUser'=>$formUser,'script'=>""]);
    }

    #[Route('/entreprise/create')]
    public function create(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $hasher, UtilisateurRepository $utilisateurRepository, EnseignantRepository $enseignantRepository): Response
    {
        if ($this->getUser()!==null) {
            return $this->redirectToRoute('app_home');
        }
        $user=new Utilisateur();
        $entreprise=new Entreprise();
        $formUser=$this->createForm(UtilisateurType::class, $user)->add('password', PasswordType::class)->add('login', TextType::class);
        $form=$this->createForm(EntrepriseType::class, $entreprise)->add(
            'submit',
            SubmitType::class,
            ['label' => 'Envoyer']
        );
        $form->handleRequest($request);
        $formUser->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logins=$utilisateurRepository->findAll();
            $entrepriseType=$form->getData();
            $userData=$formUser->getData();
            foreach ($logins as $login) {
                if ($login->getLogin()===$userData->getLogin()) {
                    return $this->renderForm('entreprise/update.html.twig', ['form'=>$form,'formUser'=>$formUser,'script'=>"javascriptAlert()"]);
                }
            }
            $entityManager=$doctrine->getManager();
            $entreprise->setNomEnt($entrepriseType->getNomEnt());
            $entreprise->setNomRef($entrepriseType->getNomRef());
            $user->setEmail($userData->getEmail());
            $user->setRoles(['ROLE_ENTREPRISE']);
            $entreprise->setIsDisabled(true);
            $user->setPassword($hasher->hashPassword($user, $userData->getPassword()));
            $user->setLogin($userData->getLogin());
            $entreprise->setCdUtil($user);
            $entityManager->persist($user);
            $entityManager->persist($entreprise);
            $entityManager->flush();
            $e=new EmailSender();
            $enseignants=$enseignantRepository->findAll();
            foreach ($enseignants as $enseignant) {
                if ($enseignant->isAdmin()) {
                    $mailer = $e->createMailSender();
                    $e->sendEmail($mailer, 'masteriareims@gmail.com', $enseignant->getCdUtil()->getEmail(), 'Notifcation', 'Une entreprise vient de créer ce compte. Il faut le valider ou non '."\n\n\n Message envoyé par le système. Ne pas répondre directement à ce mail");
                }
            }
            return $this->render('entreprise/succes.html.twig', ['user'=>$user]);
        }
        return $this->renderForm('entreprise/update.html.twig', ['form'=>$form,'formUser'=>$formUser,"script"=>'']);
    }
}
