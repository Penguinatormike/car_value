<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CarValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('make', TextType::class, [
                'label' => 'Make',
                'attr' => ['placeholder' => 'Enter the make of your car'],
                'required' => true
            ])
            ->add('model', TextType::class, [
                'label' => 'Model',
                'attr' => ['placeholder' => 'Enter the model of your car'],
                'required' => true
            ])
            ->add('trim', TextType::class, [
                'label' => 'Trim',
                'attr' => ['placeholder' => 'Enter the trim of your car'],
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Year',
                'attr' => ['placeholder' => 'Enter the year of your car'],
                'required' => true
            ])
            ->add('mileage', IntegerType::class, [
                'label' => 'Mileage',
                'attr' => ['placeholder' => 'Enter the mileage of your car'],
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Get Valuation',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}