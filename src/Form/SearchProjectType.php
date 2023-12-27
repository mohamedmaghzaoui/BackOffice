<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
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
        ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Customize form options if needed
        ]);
    }
}
