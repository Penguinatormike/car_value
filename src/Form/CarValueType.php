<?php

namespace App\Form;

use App\Entity\Dealer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class CarValueType extends AbstractType
{
    const MAKE = 'make';
    const MODEL = 'model';
    const YEAR = 'year';
    const TRIM = 'trim';
    const MILEAGE = 'mileage';
    const STATE = 'state';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::MAKE, TextType::class, [
                'label' => 'Make',
                'attr' => ['placeholder' => 'Make of your car'],
                'constraints' => [new NotBlank()],
                'required' => true,
                'trim' => true,
            ])
            ->add(self::MODEL, TextType::class, [
                'label' => 'Model',
                'attr' => ['placeholder' => 'Model of your car'],
                'constraints' => [new NotBlank()],
                'required' => true,
                'trim' => true,
            ])
            ->add(self::YEAR, ChoiceType::class, [
                'label' => 'Year',
                'required' => true,
                'constraints' => [new NotBlank(), new Positive()],
                'choices' => ["" => ""] + array_reverse(
                    range(0, (int) (new \DateTime())->format('Y') + 1), // 0 - currentYear + 1
                    true
                )
            ])
            ->add(self::TRIM, TextType::class, [
                'label' => 'Trim',
                'attr' => ['placeholder' => 'Trim of your car'],
                'required' => false,
                'trim' => true,
            ])
            ->add(self::MILEAGE, IntegerType::class, [
                'label' => 'Mileage',
                'attr' => ['placeholder' => 'Mileage of your car'],
                'constraints' => [new Positive()],
                'required' => false,
                'trim' => true,
            ])
            ->add(self::STATE, ChoiceType::class, [
                'label' => 'State/Province',
                'attr' => ['placeholder' => 'State or province'],
                'choices' => array_flip(Dealer::AMERICAN_STATE_MAP + Dealer::CANADIAN_PROV_MAP),
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Get Valuation',
                'attr' => ['class' => 'btn btn-primary']
            ])->getForm();
    }
}