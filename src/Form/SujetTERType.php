<?php

namespace App\Form;

use App\Entity\Enseignant;
use App\Entity\Niveau;
use App\Entity\SujetTER;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SujetTERType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreTer', TextType::class, ['attr' => ['oninvalid' => "setCustomValidity('Titre manquant')"]])
            ->add('descTer', TextareaType::class, ['attr' => ['style' => 'height:250px',
                                                                    'oninvalid' => "setCustomValidity('Descriptif manquant')"]])
            ->add('niveau', EntityType::class, [
                            'required' => true,
                            'attr' => ['oninvalid' => "setCustomValidity('Veuillez sélectionner un niveau')"],
                            'placeholder' => 'Niveau ?',
                            'class' => Niveau::class,
                            'choice_label' => 'libNiv',
                            'query_builder' => function (EntityRepository $entityRepository) {
                                return $entityRepository->createQueryBuilder('niv')
                                    ->orderBy('niv.libNiv', 'ASC');
                            },
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SujetTER::class,
        ]);
    }
}
