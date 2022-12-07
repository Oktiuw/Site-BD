<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

use function Sodium\add;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo', FileType::class, ['label'=>'Photo de profil ( png/jpg/jpeg uniquement)','mapped'=>false,'required'=>true,
                'constraints'=>[new File(['maxSize'=>'1024k','mimeTypes'=>
                    ['image/jpeg','image/png','image/jpg'],'mimeTypesMessage'=>'Veuillez choisir un document valide'])]])
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, ['required'=>false,'empty_data'=>'rien'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
