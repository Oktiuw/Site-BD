<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Entity\Entreprise;
use App\Form\EmailType;
use App\Mail\EmailSender;
use App\Repository\EntrepriseRepository;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Framework\RequestConfig;

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
    #[Route('/contact/entreprise', name: 'app_contact_entreprise')]
    public function contactEntreprise(Request $request): Response
    {
        $form=$this->createForm(EmailType::class)
            ->add('profile', EntityType::class, [
                'class' => Entreprise::class,
                'placeholder' => 'Destinataire?',
                'choice_label' => 'nomEnt',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->orderBy('c.nomEnt', 'ASC');
                },
            ])->add('submit', SubmitType::class, ['label' => 'Envoyer','attr'=>['onclick'=>'javascriptAlert()']])
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->getData();
            $e=new EmailSender();
            $mailer=$e->createMailSender();
            $e->sendEmail($mailer, $this->getUser()->getEmail(), $mail['profile']->getCdUtil()->getEmail(), $mail['objet'], $mail['body']);

            return $this->redirectToRoute('app_redirecteur');
        }
        return $this->renderForm('contact/send.html.twig', ['form'=>$form]);
    }
    #[Route('/contact/enseignant', name: 'app_contact_enseignant')]
    public function contactEnseignant(Request $request): Response
    {
        $form=$this->createForm(EmailType::class)
            ->add('profile', EntityType::class, [
                'class' => Enseignant::class,
                'placeholder' => 'Destinataire?',
                 'choice_label'=>function (Enseignant $enseignant) {
                     return strtoupper($enseignant->getNomEn()).' '.$enseignant->getPnomEn();
                 },'query_builder'=>function (EntityRepository $entityRepository) {
                     return $entityRepository->createQueryBuilder('c')->orderBy('c.nomEn', 'ASC');
                 }
            ])->add('submit', SubmitType::class, ['label' => 'Envoyer','attr'=>['onclick'=>'javascriptAlert()']])
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->getData();
            $e=new EmailSender();
            $mailer=$e->createMailSender();
            $e->sendEmail($mailer, $this->getUser()->getEmail(), $mail['profile']->getCdUtil()->getEmail(), $mail['objet'], $mail['body']);

            return $this->redirectToRoute('app_redirecteur');
        }
        return $this->renderForm('contact/send.html.twig', ['form'=>$form]);
    }
}
