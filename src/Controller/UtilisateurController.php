<?php

namespace App\Controller;

use App\Form\UtilisateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Psy\Readline\Hoa\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class UtilisateurController extends AbstractController
{
    #[Route('/updateAvatar', name: 'app_utilisateur')]
    public function index(Request $request, SluggerInterface $slugger, ManagerRegistry $doctrine): Response
    {
        $user=$this->getUser();
        $form=$this->createForm(UtilisateurType::class, $user)->add(
            'submit',
            SubmitType::class,
            ['label' => 'Modifier']
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avatar=$form->get('photo')->getData();
            if ($avatar) {
                $originalFilename=pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename=$slugger->slug($originalFilename);
                $newFilename=$safeFilename.'-'.uniqid().'.'.$avatar->guessExtension();
            }
            try {
                $avatar->move($this->getParameter('avatars_directory'), $newFilename);
            } catch (FileException $e) {
            }
            $user->setAvatar($newFilename);
            $manager=$doctrine->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->redirectToRoute('app_redirecteur');
        }
        return $this->renderForm('utilisateur/index.html.twig', [
            'form' => $form ]);
    }
}
