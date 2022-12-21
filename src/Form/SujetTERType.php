<?php

namespace App\Form;

use App\Entity\SujetTER;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SujetTERType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreTer')
            ->add('descTer')
            ->add('niveau')
            ->add('Enseignant')
            ->add('Etudiant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SujetTER::class,
        ]);
    }
}
