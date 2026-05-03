<?php

namespace App\Form;

use App\Entity\Pompiste;
use App\Entity\Station;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

/**
 * Formulaire d'inscription pour les pompistes
 * Définit les champs et les règles de validation
 */
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
            // Nom du pompiste
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre nom']),
                ],
            ])

            // Prénom du pompiste
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre prénom']),
                ],
            ])

            // Numéro de téléphone
            ->add('numero', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre numéro de téléphone']),
                ],
            ])

            // Email 
            ->add('email', TextType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre email']),
                    new Email(['message' => 'Veuillez entrer un email valide (ex: nom@domaine.com)']),
                ],
            ])

            // Champ : Sélection de la station (liste déroulante)
            // L'utilisateur voit le NOM de la station, mais le formulaire envoie son ID
            // Non mappé car on traite dans le contrôleur
            ->add('station', EntityType::class, [
                'class' => Station::class,    
                'mapped' => false,
                'choice_label' => 'nom',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez le nom de la station'],

            ])

            // Case à cocher conditions 
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter les conditions pour continuer']),
                ],
            ])

            // Mot de passe - non mappé car c'est le mot de passe hashé dans le controlleur qui va etre envoyé vers la BDD
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez choisir un mot de passe']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pompiste::class, // Lie le formulaire à l'entité Pompiste
            'entity_manager' => null,
        ]);
    }
}
