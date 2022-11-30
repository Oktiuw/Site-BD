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
        return $this->render('redirecteur/index.html.twig', [
            'controller_name' => 'RedirecteurController',
        ]);
    }
}
