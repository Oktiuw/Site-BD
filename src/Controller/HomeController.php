<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $user=$this->getUser();
        return $this->render('home/home.html.twig', ['user'=>$user]);
    }
    #[Route('/tuto',name: 'app_tuto')]
    public function tuto(): Response
    {
        return $this->render('home/tuto.html.twig');
}}
