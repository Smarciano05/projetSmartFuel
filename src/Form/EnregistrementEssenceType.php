<?php

namespace App\Form;

use App\Entity\EnregistrementEssence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class EnregistrementEssenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immatriculation', TextType::class, [
                'label' => 'Immatriculation',
                'attr' => [
                    'placeholder' => 'AA-123-AA',
                ],
                'mapped' => false,
            ])

            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'label' => 'Date et heure ',
                'disabled' => false // user ne pt pas changer
            ])
            ->add('typeCarburant', ChoiceType::class, [
                'label' => 'Type de carburant',
                'choices' => [
                    // Carburants Essence
                    'Essence' => [
                        'SP95' => 'SP95',
                        'SP98' => 'SP98',
                        'SP95-E10' => 'SP95-E10',
                        'SP98-E5' => 'SP98-E5',
                        'E10' => 'E10',
                        'E85' => 'E85',
                    ],
                    // Carburants Diesel/Gazole
                    'Diesel/Gazole' => [
                        'Gazole' => 'Gazole',
                        'B7' => 'B7',
                        'B10' => 'B10',
                    ],
                    // Autres carburants
                    'Autres' => [
                        'GPLc' => 'GPLc',
                    ],
                ],
                'placeholder' => 'Sélectionnez un type de carburant',
                'attr' => [
                    'class' => 'form-control',
                ],

            ])
            ->add('quantite', TextType::class, [
                'label' => 'Quantité (en litres)',
                'attr' => [
                    'placeholder' => 'Ex: 50.0',
                ],
            ])
            ->add('client_email', EmailType::class, [
                'label' => 'Email du Client',
                'attr' => ['placeholder' => 'client@exemple.com'],
                'mapped' => false, // On ne l'enregistre pas directement on s'en sert comme une clé
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EnregistrementEssence::class,
        ]);
    }
}
