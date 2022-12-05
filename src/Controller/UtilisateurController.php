<?php

namespace App\Controller;

use App\Form\UtilisateurType;
use GuzzleHttp\Psr7\Request;
use Psy\Readline\Hoa\FileException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UtilisateurController extends AbstractController
{
    #[Route('/updateAvatar', name: 'app_utilisateur')]
    public function index(Request $request, SluggerInterface $slugger): Response
    {
        $user=$this->getUser();
        $form=$this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avatar=$form->get('photo')->getData();
            if ($avatar) {
                $originalFilename=pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename=$slugger->slug($originalFilename);
                $newFilename=$safeFilename.'-'.uniqid().'.'.$avatar->guessExtension();
            }
            try{
                $avatar->move($this->getParameter('avatars_directory'))
            } catch (FileException $e){}
            $user->setAvatar($newFilename);
        }
        return $this->renderForm('utilisateur/index.html.twig', [
            'form' => $form ]);
    }
}
