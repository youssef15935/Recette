<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('fullName', TextType::class, [
                'attr' => [
                    'class' => 'form-control ',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'label' => 'Nom / Prenom',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50]),
                ]


            ])
            ->add('pseudo', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50',
                ],
                'required' => false,
                'label' => 'pseudo',
                'label_attr' => [
                'class' => 'form-labe mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Pseudo is required.',
                    ])
                ]


            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '180',
                ],
                'label' => 'Adress email',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 180]),
                    new Assert\Email(),
                    new Assert\NotBlank()

                ]

            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [ 
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'form-control mt-4',
                    ],
                ],
                'second_options' => [ 
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                        'class' => 'form-control mt-4',
                    ],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas',
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
