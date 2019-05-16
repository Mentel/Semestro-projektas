<?php


namespace App\Form;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateCategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])->add('newName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Įveskite kategorijos pavadinimą',
                    ]),
                    new Length([
                        'max' => 20,
                        'maxMessage' => 'Maksimalus leistinas kategorijos pavadinimo ilgis: {{ limit }}',
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'selected' => null,
        ));
    }
}