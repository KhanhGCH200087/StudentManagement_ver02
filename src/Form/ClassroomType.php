<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ClassroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('name')
            // ->add('quantity')
            // ->add('description')
            // ->add('teacher')
            ->add('name', TextType::class, 
            [
                'required' => true,
                'label' => 'Enter name here' 
            ])
            ->add('quantity', IntegerType::class, 
            [
                'required' => true,
                'label' => 'Enter quantity here',
                'attr' => [
                    'min' => 10,
                    'minMessage' => 'Quantity must at least 10',
                    'max' => 30,
                    'maxMessage' => 'Quantity must less than 30',
                ]
            ])
            ->add('description', TextType::class, 
            [
                'required' => true,
                'label' => 'Enter Description here',
            ])
            
            ->add('teacher', EntityType::class,
            [
                'label' => 'Teacher',
                'required' => false,
                'class' => Teacher::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,
        ]);
    }
}
