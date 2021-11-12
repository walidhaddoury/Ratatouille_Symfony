<?php

namespace App\Form;

use App\Entity\Activity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('activity_name',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Activity Name",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 32
                    ]
                ]
            )
            ->add('activity_date',
                DateType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Date",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 100
                    ]
                ])
            ->add('is_finish',
                EmailType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Mail",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 100
                    ]
                ])
            ->add('members',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Members",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 100
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
