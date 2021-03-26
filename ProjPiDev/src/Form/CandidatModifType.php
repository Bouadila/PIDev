<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatModifType extends AbstractType
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


                   ->add('mdp', RepeatedType::class,array(

                           'type'   => PasswordType::class,
                           'first_options'=>array('label'=>'mot de passe'),
                           'second_options'=>array('label'=>'repeter le mot de passe'),

                       )
                   )
                   ->add('Save', SubmitType::class,[

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


                   ->add('img', FileType::class,array('data_class' => null))
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
                       'choices' => [
                           'English' => 'en',
                           'Spanish' => 'es',
                           'Bork' => 'muppets',
                           'Pirate' => 'arr',
                       ],
                       'preferred_choices' => ['muppets', 'arr' ],
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
