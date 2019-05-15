<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Įveskite renginio pavadinimą',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Minimalus leistinas renginio pavadinimo ilgis: {{ limit }}',
                        'max' => 255,
                        'maxMessage' => 'Maksimalus leistinas renginio pavadinimo ilgis: {{ limit }}',
                    ]),
                ]
            ])
            ->add("date", DateType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Pasirinkite renginio laiką',
                    ]),
                ]
            ])
            ->add("address", TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Įveskite renginio adresą',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Minimalus leistinas renginio adreso ilgis: {{ limit }}',
                        'max' => 255,
                        'maxMessage' => 'Maksimalus leistinas renginio adreso ilgis: {{ limit }}',
                    ]),
                ]
            ])
            ->add("price", MoneyType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Įveskite kaina',
                    ]),
                    new Length([
                        'max' => 5,
                        'maxMessage' => 'Maksimalus leistinas kainos ilgis: {{ limit }}',
                    ]),
                ]
            ])
            ->add("description", TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Įveskite renginio aprašymą',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Minimalus leistinas renginio aprašymo ilgis: {{ limit }}',
                        'max' => 2000,
                        'maxMessage' => 'Maksimalus leistinas renginio aprašymo ilgis: {{ limit }}',
                    ]),
                ]
            ]);
    }
}