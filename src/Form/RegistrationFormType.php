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


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre nom']),
                ],
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre prénom']),
                ],
            ])
            ->add('numero', IntegerType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre numéro de téléphone']),
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre email']),
                    new Email(['message' => 'Veuillez entrer un email valide (ex: nom@domaine.com)']),
                ],
            ])
            /* Champ temporaire pour l'ID de la station */
            ->add('stationId', IntegerType::class, [
                'mapped' => false,
                'label' => 'Numéro de la Station',
                'required' => true,
                'attr' => ['placeholder' => 'Entrez l\'ID de la station'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer l\'ID de la station essence']),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter les conditions pour continuer']),
                ],
            ])
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

        // Ajouter un écouteur d'événement pour convertir l'ID en objet Station
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $user = $event->getData();
            $stationId = $form->get('stationId')->getData();

            if ($stationId && $user) {
                // Récupérer l'EntityManager via le formulaire
                $entityManager = $form->getConfig()->getOption('entity_manager');
                if ($entityManager) {
                    $station = $entityManager->getRepository(Station::class)->find($stationId);
                    if ($station) {
                        $user->setStation($station);
                    }
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pompiste::class,
            'entity_manager' => null, // Sera passé par le contrôleur
        ]);
    }
}