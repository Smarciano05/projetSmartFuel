<?php

namespace App\Form;

use App\Entity\EnregistrementEssence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnregistrerEssenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immatriculation', TextType::class , [
                'label' => 'Immatriculation',
                'attr' => [
                    'placeholder' => 'AA-123-AA',
                ],
                'mapped'=> false,
            ])
            ->add('date', DateTimeType::class,[
                'widget' => 'single_text',
                'label' => 'Date et heure de l\'enregistrement',
            ])
            ->add('typeCarburant', ChoiceType::class , [
                'label' => 'Type de carburant',
                'choices' => [
                    'Essence' => 'Essence',
                    'Diesel' => 'Diesel',
                    'Gazole' => 'Gazole',
                    'Électrique' => 'Électrique',
                    'Premium'=> 'Premium',
                ],
                'attr' => [
                    'placeholder' => 'Ex: Essence',
                ],
            ])
            ->add('quantite', TextType::class , [
                'label' => 'Quantité (en litres)',
                'attr' => [
                    'placeholder' => 'Ex: 50.0',
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        //permet de relier au formulaire à l'entité EnregistrementEssence
        $resolver->setDefaults([
            'data_class' => EnregistrementEssence::class,
        ]);
    }
}
