<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        $user=$this->getUser();
        if ($user->getRoles()[0]==='ROLE_ENTREPRISE') {
            $entreprise=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
            if ($entreprise->isIsdisabled()) {
                return $this->redirectToRoute('app_redirecteur');
            }
        }
        return $this->render('contact/index.html.twig', [
            'user' => $user,
        ]);
    }
}
