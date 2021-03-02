<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('TitreDemande' , TextType::class,[
        'attr'=>[
            'placeholder'=>'Titre',
            'name'=>'name',
        ]
    ])
            ->add('nomCand', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Nom',
                    'name'=>'name',
                ]
            ])
            ->add('prenomCand', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Prénom',
                    'name'=>'name',
                ]
            ])
            ->add('emailCand',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Email',
                    'name'=>'name',
                ]
            ])
            ->add('numCand', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Numéro',
                    'name'=>'name',
                ]
            ])
            ->add('adresseCand', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Adresse',
                    'name'=>'name',
                ]
            ])
            ->add('domaineTravail', ChoiceType::class,[
                'choices'  => [
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

            ->add('statutCand', ChoiceType::class,[
                'choices'  => [
                    'Bac' => 'Bac',
                    'Licence' => 'Licence',
                    'Master' => 'Master',
                    'Doctorat' => 'Doctorat',

                ],
            ])
            ->add('description', TextType::class,[
                'attr'=>[
                    'placeholder'=>'Description',
                    'name'=>'name',
                ]
            ])

           ->add('cvCand', FileType::class, array('data_class' => null , 'label' => 'Choisissez votre fichier'))
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
