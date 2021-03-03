<?php

namespace App\Form;

use App\Entity\Candidat;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
            ->add('email', EmailType::class,[
                'attr'=>[
//                    'required'   => true,
                    'placeholder'=>'Email',
                    'name'=>'name',
                ]
            ])

            ->add('genre', ChoiceType::class,[
                'choices'  => [
                    'choisir votre sexe' => null,
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
            ])
            ->add('date_naisse', DateType::class,[

            ])
//            ->add('date_naiss',DateType::class, [
//                'attr' => ['class' => 'bootstrap-daterangepicker']
//
//            ])

//            ->add('date_naiss', DateType::class,[
//                'placeholder'  => [
//                    'genre' => null,
//                    'Homme' => true,
//                    'Femme' => false,
//                ],
//            ])

            ->add('mdp', PasswordType::class,array(

                'attr'=>[
//                    'required'   => true,
                    'placeholder'=>'mot de passe',
                    'name'=>'name',
                ]
            ))
//            ->add('mdp', RepeatedType::class,array(
//
//                    'type'   => PasswordType::class,
//                    'first_options'=>array('label'=>'mot de passe'),
//                    'second_options'=>array('label'=>'repeter le mot de passe'),
//
//            )
//            )
            ->add('SignUp', SubmitType::class,[

            ])


               ->add('gover', ChoiceType::class,
                   [
                   'choices'  => [
                       'choisir votre gouvernora' => null,
                       'Ariana' => 'Ariana',
                       'Ben Arous' => 'Ben Arous',
                       'Kairouan' => 'Kairouan',
                       'Kébili' => 'Kébili',
                       'Nabeul' => 'Nabeul',

                   ],
               ])


            ->add('img', FileType::class,array('data_class' => null))
            ->add('num', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'numero',
                    'name'=>'name',
                ]
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
            ->add('diplome',TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'diplome',
                    'name'=>'name',
                ]
            ])

            ->add('cv', FileType::class ,array('data_class' => null))
        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }


}


