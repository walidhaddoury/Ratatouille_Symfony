<?php

namespace App\Form;

use App\Entity\Spent;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('expense_name',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Name",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 100
                    ]
                ])
            ->add('cost',
                IntegerType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => "Cost",
                        'class' => "p-3 mt-1 block w-full border-none bg-gray-100 h-11 rounded-xl shadow-lg hover:bg-blue-100 focus:bg-blue-100 focus:ring-0",
                        'maxlength' => 100
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Spent::class,
        ]);
    }
}
