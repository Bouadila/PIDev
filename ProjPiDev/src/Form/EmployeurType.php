<?php

namespace App\Form;

use App\Entity\Employeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('mdp')
            ->add('email')
            ->add('nom_entreprise')
            ->add('site_entreprise')
            ->add('adresse_entreprise')
            ->add('num_employeur')
            ->add('logo')
            ->add('description')
            ->add('secteur')
            ->add('candidats')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employeur::class,
        ]);
    }
}
