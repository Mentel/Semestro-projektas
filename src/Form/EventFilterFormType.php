<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EventFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $now=new \DateTime('now');

        $builder
            ->add("date", DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => 'empty'
            ])
            ->add("dateTo", DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'empty_data' => 'empty'
            ])
            ->add("price", MoneyType::class, [
                'required' => false,
                'empty_data' => 'empty'
            ])
            ->add('filter', SubmitType::class, [
            ]);
    }
}