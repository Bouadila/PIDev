<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('salaire')
            ->add('dateExpiration',DateTimeType::class, [
                'date_widget' => 'single_text'
            ])
            ->add('nombrePlace')
            ->add('experienceMin')
            ->add('experienceMax')
            ->add('contrat',EntityType::class, ['class' => Contrat::class,'choice_label' => 'type' , 'expanded'=>true, 'multiple'=>false])
            ->add('post')
            ->add('objectif')
            ->add('competences')
            ->add('domaine', ChoiceType::class,[
                'choices'  => [
                    ''=>'',
                    'Aéronautique Et Espace' => 'Aéronautique Et Espace',
                    'Agriculture - Agroalimentaire' => 'Agriculture - Agroalimentaire',
                    'Artisanat' => 'Artisanat',
                    'Audiovisuel, Cinéma' => 'Audiovisuel, Cinéma',
                    'Audit, Comptabilité, Gestion' => 'Audit, Comptabilité, Gestion',
                    'Automobile' => 'Automobile',
                    'Banque, Assurance' => 'Banque, Assurance',
                    'Bâtiment, Travaux Publics' => 'Bâtiment, Travaux Publics',
                    'Biologie, Chimie, Pharmacie' => 'Biologie, Chimie, Pharmacie',
                    'Commerce, Distribution' => 'Commerce, Distribution',
                    'Communication' => 'Communication',
                    'Création, Métiers art' => 'Création, Métiers art',
                    'Culture, Patrimoine' => 'Culture, Patrimoine',
                    'Défense, Sécurité, Armée' => 'Défense, Sécurité, Armée',
                    'Documentation, Bibliothèque' => 'Documentation, Bibliothèque',
                    'Droit' => 'Droit',
                    'Edition, Livre' => 'Edition, Livre',
                    'Enseignement' => 'Enseignement',
                    'Environnement' => 'Environnement',
                    'Ferroviaire' => 'Ferroviaire',
                    'Foires, Salons Et Congrès' => 'Foires, Salons Et Congrès',
                    'Fonction Publique' => 'Fonction Publique',
                    'Hôtellerie, Restauration' => 'Hôtellerie, Restauration',
                    'Humanitaire' => 'Humanitaire',
                    'Immobilier' => 'Immobilier',
                    'Industrie' => 'Industrie',
                    'Informatique, Télécoms, Web' => 'Informatique, Télécoms, Web',
                    'Jeu Vidéo' => 'Jeu Vidéo',
                    'Journalisme' => 'Journalisme',
                    'Langues' => 'Langues',
                    'Marketing, Publicité' => 'Marketing, Publicité',
                    'Médical' => 'Médical',
                    'Mode-Textile' => 'Mode-Textile',
                    'Paramédical' => 'Paramédical',
                    'Propreté Et Services Associés' => 'Propreté Et Services Associés',
                    'Psychologie' => 'Psychologie',
                    'Ressources Humaines' => 'Ressources Humaines',
                    'Sciences Humaines Et Sociales' => 'Sciences Humaines Et Sociales',
                    'Secrétariat' => 'Secrétariat',
                    'Social' => 'Social',
                    'Spectacle - Métiers De La Scène' => 'Spectacle - Métiers De La Scène',
                    'Sport' => 'Sport',
                    'Tourisme' => 'Tourisme',
                    'Transport-Logistique' => 'Transport-Logistique',
                ],
            ])
            ->add('test', ChoiceType::class,[
                'label' =>'ajouter quiz',
                'mapped'=> false,
                'choices'  => [
                    'non'=>'non',
                    'oui' => 'oui',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
