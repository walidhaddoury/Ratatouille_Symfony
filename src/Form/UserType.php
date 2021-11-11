<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Prénom",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 32
                    ]
                ]
            )
            ->add('last_name',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Nom",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-17 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 32
                    ]
                ])
            ->add('mail',
                EmailType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "E-mail",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 100
                    ]
                ])
            ->add('picture',
                FileType::class,
                [
                    'required' => false,
                ])
            ->add('password',
                PasswordType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Mot de passe",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 100
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
