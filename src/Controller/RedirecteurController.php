<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirecteurController extends AbstractController
{
    #[Route('/redirecteur', name: 'app_redirecteur')]
    public function index(): Response
    {
        if ($this->getUser()->getRoles()[0]=="ROLE_ETUDIANT") {
            return $this->redirectToRoute('app_etudiant');
        }
        if ($this->getUser()->getRoles()[0]=="ROLE_ENTREPRISE") {
            return $this->redirectToRoute('app_entreprise');
        }
        return $this->redirectToRoute('app_enseignant');
    }
}
