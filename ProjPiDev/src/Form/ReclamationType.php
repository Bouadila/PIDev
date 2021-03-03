<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'Veuillez ecrire votre titre de reclamation',
                    'nom'=>'title',
                ]
            ])
            ->add('description_Reclamation', TextType::class,[
                'attr'=>[
                    'required'   => true,
                    'placeholder'=>'Veuillez decrire votre probleme',
                    'nom'=>'description_Reclamation',
                ]
            ])
            ->add('type', ChoiceType::class,[
                'choices'  => [
                    'Choisir le type de reclamation' => null,
                    'Profile' => 'Profile',
                    'General' => 'General',
                ],
            ])
            ->add('Submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
