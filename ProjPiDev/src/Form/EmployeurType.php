<?php

namespace App\Form;

use App\Entity\Employeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EmployeurType extends AbstractType
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


            ->add('mdp', PasswordType::class,array(

                'attr'=>[
//                    'required'   => true,
                    'placeholder'=>'mot de passe',
                    'name'=>'name',
                ]
            ))
            ->add('SignUp', SubmitType::class,[]

            )


            ->add('secteur', ChoiceType::class,
                [
                    'choices'  => [
                        'choisir un secteur' => null,

                        'Informatique' => 'Informatique',
                        'Science' => 'Science',
                        'Recherche' => 'Recherche',
                        'Immobilier' => 'Immobilier',
                    ],
                ])
            ->add('logo', FileType::class,array('data_class' => null))
            ->add('num_employeur', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'numero',
                    'name'=>'name',
                ]
            ])
            ->add('nom_entreprise', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'name'=>'name',
                ]
            ])
            ->add('site_entreprise', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'name'=>'name',
                ]
            ])
            ->add('adresse_entreprise', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'name'=>'name',
                ]
            ])
            ->add('num_employeur', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'name'=>'name',
                ]
            ])
            ->add('description', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'name'=>'name',
                ]
            ])
           
//            ->add('candidats')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employeur::class,
        ]);
    }
}
