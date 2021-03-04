<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('salaire')
            ->add('dateExpiration')
            ->add('nombrePlace')
            ->add('experience')
            ->add('contrat',EntityType::class, ['class' => Contrat::class,'choice_label' => 'type' , 'expanded'=>true, 'multiple'=>false])
            ->add('post')
            ->add('objectif')
            ->add('competences')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
