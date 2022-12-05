<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/home/{connexion}', name: 'app_home2')]
    public function connexion(string $connexion): Response
    {
        return $this->render('home/connexion.html.twig' , ['connexion' => $connexion]);
    }
}
