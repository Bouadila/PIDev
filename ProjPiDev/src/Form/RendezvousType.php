<?php

namespace App\Form;

use App\Entity\Candidature;
use App\Entity\Rendezvous;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezvousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('start', DateTimeType::class, [
                'date_widget' => 'single_text'
             ])
            ->add('end', DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('description')
            ->add('all_day')
            ->add('background_color',ColorType::class)
            ->add('border_color',ColorType::class)
            ->add('text_color',ColorType::class)
            ->add('candidature',EntityType::class, ['class' => Candidature::class,'choice_label' => 'titre' , 'expanded'=>true, 'multiple'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rendezvous::class,
        ]);
    }
}
