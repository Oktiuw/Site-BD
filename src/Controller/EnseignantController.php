<?php

namespace App\Controller;

use App\Form\EntrepriseType;
use App\Form\UtilisateurType;
use App\Repository\EnseignantRepository;
use App\Repository\EntrepriseRepository;
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
        $profile=$enseignantRepository->findOneBy(['id'=>$user->getId()]);
        return $this->render('enseignant/index.html.twig', [
            'user' =>$user,'profile'=>$profile]);
    }
}



