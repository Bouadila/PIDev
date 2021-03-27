<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('name', TextType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password']
            ])
            ->add('prenom', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'Prenom',
                    'name'=>'name',
                ]
            ])
            ->add('gover', ChoiceType::class,
                [
                    'choices'  => [
                        'choisir votre gouvernora' => null,
                        'Ariana' => 'Ariana',
                        'Tunis'=>'Tunis',
                        'Ben Arous' => 'Ben Arous',
                        'Kairouan' => 'Kairouan',
                        'Kébili' => 'Kébili',
                        'Nabeul' => 'Nabeul',

                    ],
                ])

            ->add('image',FileType::class,[
                'mapped' => false
            ])

            ->add('special', ChoiceType::class,
                [
                    'choices'  => [
                        'choisir votre specialité' => null,
                        'informatique' => 'informatique',
                        'Science' => 'Science',
                        'Math' => 'Math',
                        'Immobilier' => 'Immobilier',

                    ],
                ])
            ->add('nom_entre', TextType::class,[
               'attr'=>[
                    'label'=> 'nom entreprise',
                    'required'   => true,
                   'name'=>'name',
                ]
           ])
            ->add('SignUp', SubmitType::class,[

            ])

            ->add('nom_entre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
