<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ResetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class ,[

                'constraints' => [new NotBlank([
                    'message' => 'Įveskite elektroninį paštą',
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'El. pastas turi turėti bent {{ limit }} simbolius',
                    // max length allowed by Symfony for security reasons
                    'max' => 255,
                ])]
            ])
        ;
    }

}
