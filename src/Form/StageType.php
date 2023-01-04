<?php

namespace App\Form;

use App\Entity\Niveau;
use App\Entity\Stage;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreStage', TextType::class, ['attr' => ['oninvalid' => "setCustomValidity('Titre manquant')"]])
            ->add('descStage', TextareaType::class, ['attr' => ['style' => 'height:250px',
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
            ->add('adStage', TextType::class, ['attr' => ['oninvalid' => "setCustomValidity('Adresse manquante')"]])
            ->add('cpStage', TextType::class, ['attr' => ['oninvalid' => "setCustomValidity('Code postal manquant')"]])
            ->add('villeStage', TextType::class, ['attr' => ['oninvalid' => "setCustomValidity('Ville manquante')"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
