<?php

namespace App\Controller;

use App\Entity\SujetTER;
use App\Repository\SujetTERRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SujetTERController extends AbstractController
{
    #[Route('/sujetter', name: 'app_sujet_ter')]
    public function index(SujetTERRepository $sujetTERRepository): Response
    {
        $sujetsTER = $sujetTERRepository->findBy([], ['titreTer'=> 'ASC']);
        return $this->render('sujet_ter/index.html.twig', [
            'sujetsTER' => $sujetsTER,
        ]);
    }


}
