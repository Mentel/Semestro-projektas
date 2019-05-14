<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateCategoryFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categoryName', TextType::class, [
                'label' => 'Kategorijos pavadinimas',
                'constraints' => [
                    new NotBlank([
                    'message' => 'Įveskite kategorijos pavadinimą', ]),
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Maksimalus leistinas kategorijos pavadinimo ilgis: {{ limit }}',
                    ]),
        ]
    ]);
    }

}