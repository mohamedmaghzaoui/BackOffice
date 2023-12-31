<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("searchTerm", TextType::class, [

            'required' => false,
            'attr' => [
                'placeholder' => "search a project",
                'class' => ' form-control text-light fw-bold border-0',
                'style' => 'background: #1F2937; width:60%;',
            ],
        ])
            ->add('filterTerm', ChoiceType::class, [
                'choices' => [
                    'Education' => 'education',
                    'Work' => 'work',
                    'Personal' => 'personal',
                ],
                'expanded' => true, // This makes the checkboxes instead of a dropdown
                'multiple' => true, // This allows selecting multiple options
                'required' => false,


            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Customize form options if needed
        ]);
    }
}
