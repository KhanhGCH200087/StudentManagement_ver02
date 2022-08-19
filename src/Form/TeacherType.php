<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('name')
            // ->add('age')
            // ->add('gender')
            // ->add('image')
            // ->add('email')
            // ->add('pass')
            // ->add('classrooms')
            ->add('name', TextType::class, 
            [
                'required' => true,
                // 'mapped' => false, 
                'label' => 'Teacher name', 
                'attr' => [
                    'minlength' => 2,
                ]
            ])

            ->add('age', IntegerType::class, 
            [
                'required' => true, 
                // 'mapped' => false, 
                'label' => 'Teacher age',
                'attr' => [
                    'min' => 20,
                    'minMessage' => 'Age must at least 20',
                    'max' => 80,
                    'maxMessage' => 'Age must less than 81',
                ]
            ]) 

            ->add('gender', TextType::class, 
            [
                'required' => true, 
                // 'mapped' => false, 
                'label' => 'Teacher gender',
            ]) 

            ->add('image', TextType::class, 
            [
                'required' => true, 
                // 'mapped' => false, 
                'label' => 'Teacher image',
            ])

            ->add('email', EmailType::class, 
            [
                // 'mapped' => false, 
                'required' => true, 
                'label' => 'Teacher email',
            ]) 

            ->add('pass', PasswordType::class, 
            [
                // 'mapped' => false, 
                'required' => true, 
                'label' => 'Teacher password',
            ]) 

            // ->add('classrooms', EntityType::class,
            // [
            //     'label' => 'Class',
            //     'required' => false,
            //     'class' => Classroom::class,
            //     'choice_label' => 'name',
            //     'multiple' => true,
            //     'expanded' => true
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
