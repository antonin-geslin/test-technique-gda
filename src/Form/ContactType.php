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


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ]

        ])
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
            ]
        ])
        ->add('subject', TextType::class, [
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Sujet',
            'label_attr' => [
                'class' => 'form-label',
            ]
        ])
        ->add('message', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Message',
            'label_attr' => [
                'class' => 'form-label',
            ],
            'constraints' => [
                new Assert\NotBlank(),
            ]
            ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4',
            ],
            'label' => 'Envoyer le message',
        ]);
    }
}



?>