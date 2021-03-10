<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'Veuillez ecrire le titre de votre Annonce',
                    'name'=>'nom',
                    'id'=>'name',
                    'class'=>'form-control',
                ]
            ])
            ->add('origine', ChoiceType::class,[

                'choices'=>[
                    'Choisir un origine'=>null,
                    'La Presse'=>'La presse',
                    'Al Chorok'=>'Al Chorok',
                    'Le Monde'=>'Le Monde',
                    'Autre'=>'Autre',
                ]
            ])
            ->add('img', FileType::class,[
                'mapped'=>false
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
