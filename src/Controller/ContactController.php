<?php

namespace App\Controller;

use App\Entity\Enseignant;
use App\Entity\Entreprise;
use App\Entity\Etudiant;
use App\Entity\GroupeEtudiants;
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
        if ($this->isAccountDisabled($entrepriseRepository)) {
            return $this->redirectToRoute('app_redirecteur');
        }
        $user=$this->getUser();
        return $this->render('contact/index.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/contact/entreprise', name: 'app_contact_entreprise')]
    public function contactEntreprise(Request $request, EntrepriseRepository $entrepriseRepository): Response
    {
        if ($this->isAccountDisabled($entrepriseRepository)) {
            return $this->redirectToRoute('app_redirecteur');
        }
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
        return $this->formSendEmail($form, $request);
    }
    #[Route('/contact/enseignant', name: 'app_contact_enseignant')]
    public function contactEnseignant(Request $request, EntrepriseRepository $entrepriseRepository): Response
    {
        if ($this->isAccountDisabled($entrepriseRepository)) {
            return $this->redirectToRoute('app_redirecteur');
        }
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
        return $this->formSendEmail($form, $request);
    }
    #[Route('/contact/etudiant', name: 'app_contact_etudiant')]
    public function contactEtudiant(Request $request, EntrepriseRepository $entrepriseRepository): Response
    {
        if ($this->isAccountDisabled($entrepriseRepository)) {
            return $this->redirectToRoute('app_redirecteur');
        }
        $form=$this->createForm(EmailType::class)
            ->add('profile', EntityType::class, [
                'class' => Etudiant::class,
                'placeholder' => 'Destinataire?',
                'choice_label'=>function (Etudiant $etudiant) {
                    return strtoupper($etudiant->getNomEtud()).' '.$etudiant->getPnomEtud();
                },'query_builder'=>function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')->orderBy('c.nomEtud', 'ASC');
                }
            ])->add('submit', SubmitType::class, ['label' => 'Envoyer','attr'=>['onclick'=>'javascriptAlert()']])
        ;
        return $this->formSendEmail($form, $request);
    }

    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    #[Route('/contact/etudiant/{id}', name: 'app_contact_etudiant_specific', requirements: ['id'=>'\d+'])]
    public function contactEtudiantSpecific(Request $request, EntrepriseRepository $entrepriseRepository, Etudiant $etudiant): Response
    {
        if ($this->isAccountDisabled($entrepriseRepository)) {
            return $this->redirectToRoute('app_redirecteur');
        }
        $form=$this->createForm(EmailType::class)->add('submit', SubmitType::class, ['label' => 'Envoyer','attr'=>['onclick'=>'javascriptAlert()']])
        ;
        return $this->formSendEmail($form, $request, $etudiant->getCdUtil()->getEmail(), true);
    }
    #[Route('/contact/groupeEtudiants', name: 'app_contact_groupeEtudiants')]
    public function contactGroupeEtudiants(EntrepriseRepository $entrepriseRepository, Request $request): Response
    {
        if ($this->isAccountDisabled($entrepriseRepository)) {
            return $this->redirectToRoute('app_redirecteur');
        }
        $form=$this->createForm(EmailType::class)
            ->add('profile', EntityType::class, [
                'class' => GroupeEtudiants::class,
                'placeholder' => 'Destinataire?',
                'choice_label'=>'nomGroupe','query_builder'=>function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')->orderBy('c.nomGroupe', 'ASC');
                }
            ])->add('submit', SubmitType::class, ['label' => 'Envoyer','attr'=>['onclick'=>'javascriptAlert()']])
        ;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->getData();
            $e = new EmailSender();
            $mailer = $e->createMailSender();
            $etudiants=$mail['profile']->getEtudiants();
            foreach ($etudiants as $etudiant) {
                $e->sendEmail($mailer, $this->getUser()->getEmail(), $etudiant->getCdUtil()->getEmail(), $mail['objet'], $mail['body']."\n Message envoyé par le système. Ne pas répondre directement à ce mail");
            }

            return $this->redirectToRoute('app_redirecteur');
        }
        return $this->renderForm('contact/send.html.twig', ['form' => $form,'hideDest'=>false]);
    }

    /**
         * @param \Symfony\Component\Form\FormInterface $form
         * @param Request $request
         * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
         * @throws \PHPMailer\PHPMailer\Exception
         */
    public function formSendEmail(\Symfony\Component\Form\FormInterface $form, Request $request, $to=null, $hideDest=false): Response|\Symfony\Component\HttpFoundation\RedirectResponse
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->getData();
            $e = new EmailSender();
            $mailer = $e->createMailSender();
            if ($to==null) {
                $to=$mail['profile']->getCdUtil()->getEmail();
            }
            $e->sendEmail($mailer, $this->getUser()->getEmail(), $to, $mail['objet'], $mail['body']."\n Message envoyé par le système. Ne pas répondre directement à ce mail");

            return $this->redirectToRoute('app_redirecteur');
        }
        return $this->renderForm('contact/send.html.twig', ['form' => $form,'hideDest'=>$hideDest]);
    }
    public function isAccountDisabled(EntrepriseRepository $entrepriseRepository): bool
    {
        $user=$this->getUser();
        if ($user->getRoles()[0]==='ROLE_ENTREPRISE') {
            $entreprise=$entrepriseRepository->findOneBy(['cdUtil'=>$user->getId()]);
            if ($entreprise->isIsdisabled()) {
                return true;
            }
        }
        return false;
    }
}
