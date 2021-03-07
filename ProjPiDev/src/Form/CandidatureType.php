<?php

namespace App\Form;

use App\Entity\Candidature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_candidat')
            ->add('id_employeur')
            ->add('nom')
            ->add('prenom')
            ->add('sexe')
            ->add('email')
            ->add('date_naiss')
            ->add('num')
            ->add('status')
            ->add('diplome')
            ->add('cv')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidature::class,
        ]);
    }
}
