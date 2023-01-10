<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CV', FileType::class, ['label'=>'CV Etudiant ( pdf uniquement)','mapped'=>false,'required'=>false,
                'constraints'=>[new File(['maxSize'=>'3000k','mimeTypes'=>
                    ['application/pdf'],'mimeTypesMessage'=>'Veuillez choisir un document valide'])]])
            ->add('pnomEtud', TextType::class)
            ->add('adEtud', TextType::class)
            ->add('cpEtud', TextType::class)
            ->add('villeEtud', TextType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
