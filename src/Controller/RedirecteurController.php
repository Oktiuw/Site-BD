<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class RedirecteurController extends AbstractController
{
    #[Route('/redirecteur', name: 'app_redirecteur')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        if ($this->getUser()->getRoles()[0]=="ROLE_ETUDIANT") {
            return $this->redirectToRoute('app_etudiant');
        }
        if ($this->getUser()->getRoles()[0]=="ROLE_ENTREPRISE") {
            $entreprise=$entrepriseRepository->find($this->getUser()->getId());
            if ($entreprise->isIsDisabled()) {
                return $this->render('entreprise/succes.html.twig');
            }
            return $this->redirectToRoute('app_entreprise');
        }
        return $this->redirectToRoute('app_enseignant');
    }
}
