<?php

namespace App\Form;

use App\Entity\Candidature;
use App\Entity\Offre;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePostuler',DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('noteQuiz')
            ->add('candidat',EntityType::class, ['class' => User::class,'choice_label' => 'email' ])
            ->add('offre',EntityType::class, ['class' => Offre::class,'choice_label' => 'post' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
