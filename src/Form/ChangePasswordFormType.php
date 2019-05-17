<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Senas slaptažodis',
                'constraints' => [new NotBlank([
                    'message' => 'Įveskite dabartinį slaptažodį',
                ])]
            ])
            ->add('newPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Laukai turi sutapti',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Įveskite slaptažodį',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Slaptažodis turi turėti bent {{ limit }} simbolius',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options'  => ['label' => 'Slaptažodis'],
                'second_options' => ['label' => 'Slaptažodis (pakartokite)'],
            ]);
    }
}