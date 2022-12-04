<?php

namespace App\Controller;

use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[IsGranted('ROLE_ENTREPRISE')]
class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        $user=$this->getUser();
        $profile=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $avatar=null;
        if ($user->getAvatar() !== null)
        {
            $avatar=$user->setAvatar(base64_encode(stream_get_contents($user->getAvatar())));
        }
        return $this->render('entreprise/index.html.twig', [
            'user' =>$user,'profile'=>$profile,'avatar'=>$avatar
        ]);
    }
    #[Route('/entreprise/update')]
    public function update(EntrepriseRepository $entrepriseRepository,ManagerRegistry $doctrine,Request $request):Response
    {
        $entrepriseType=new EntrepriseType();
        $user=$this->getUser();
        $entreprise=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
        $form=$this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);
        return $this->renderForm('entreprise/update.html.twig',['form'=>$form]);
    }
}
