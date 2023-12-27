<?php
//search skill form
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('searchTerm', TextType::class, [

            'required' => false,
            'attr' => [
                'placeholder' => "search a skill",
                'class' => ' form-control text-light fw-bold border-0',
                'style' => 'background: #1F2937; width:60%;',
            ],
        ]);
        $builder->add('sortBy', ChoiceType::class, [
            'required' => false,
            'attr' => [

                'class' => 'btn btn-warning dropdown-toggle my-2',
                'style' => ' width:15%;',
            ],

            'choices' => [
                'Name' => 'Name',
                'Mastery' => 'Mastery',
                'date' => 'date',
                // Add more choices based on your entity fields
            ],
        ]);
        $builder->add('sortOrder', ChoiceType::class, [
            'required' => false,

            'attr' => [


                'class' => 'btn btn-warning dropdown-toggle my-2',
                'style' => ' width:15%;',
            ],

            'choices' => [
                'Ascending' => 'asc',
                'Descending' => 'desc',
                // Add more choices based on your entity fields
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
