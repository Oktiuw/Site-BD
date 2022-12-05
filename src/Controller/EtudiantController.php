<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use App\Repository\EtudiantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
