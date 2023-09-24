<?php 
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Email',
            'label_attr' => [
                'class' => 'form-label',
            ], 
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email(),
                new Assert\Length(['min' => 2, 'max' => 180]),
            ]
        ])
        ->add('pseudo', TextType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Pseudo',
            'label_attr' => [
                'class' => 'form-label',
            ], 
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 3, 'max' => 50]),
            ]
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ],
            'second_options' => [
                'label' => 'Confirmation du mot de passe',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.' 
        ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4',
            ],
            'label' => 'S\'inscrire',
        ]);

    }
}

?>