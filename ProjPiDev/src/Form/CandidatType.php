<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'Nom',
                    'name'=>'name',
                    // 'id'=>'id_Nom',
                ]
            ])
            ->add('prenom', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'Prenom',
                    'name'=>'name',
                ]
            ])
            ->add('email',TextType::class,[
        'attr'=>[
            'required'   => true,
            'placeholder'=>'Email',
            'name'=>'name',
        ]
    ])
            ->add('genre', ChoiceType::class,[
                'choices'  => [
                    'genre' => null,
                    'Homme' => true,
                    'Femme' => false,
                ],
            ])
            ->add('date_naiss', ChoiceType::class,[
                'choices'  => [
                    'genre' => null,
                    'Homme' => true,
                    'Femme' => false,
                ],
            ])
            ->add('mdp', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'mdp',
                    'name'=>'name',
                ]
            ])

            ->add('SignUp', SubmitType::class,[

            ])

            ->add('gover', ChoiceType::class,
                [
                    'choices'  => [
                        'Ariana' => 'Ariana',
                        'Ben Arous' => 'Ben Arous',
                        'Kairouan' => 'Kairouan',
                        'Kébili' => 'Kébili',
                        'Nabeul' => 'Nabeul',

                    ],
                ])
            ->add('img', FileType::class,[
                'constraints' => [
                    new File([
                        'maxSize' => '6000k',
                        'mimeTypes' => [
                            'application/jpg',
                            'application/png',
                        ],
                        'mimeTypesMessage' => 'svp mettre un fichier jpg ou png',
                    ])],
            ])
            ->add('num', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'numero',
                    'name'=>'name',
                ]
            ])
            ->add('special', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'name'=>'name',
                ]
            ])
            ->add('diplome', ChoiceType::class,[
                'choices'  => [
                    'Bac' => 'Bac',
                    'Ingénieur' => 'Ingénieur',
                    'Master' => 'Kairouan',
                    'Doctorat' => 'Kébili',

                ],
            ])
            ->add('cv', FileType::class,[
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'svp mettre un fichier pdf ',
                    ])],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
