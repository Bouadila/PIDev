<?php

namespace App\Entity;

use App\Repository\EmployeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraint\Email;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Validator\Constraints\Image ;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EmployeurRepository::class)
 */
class Employeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre nom")
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre prenom")
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre mdp")
     * @Assert\Length(min=2 , minMessage="votre mdp {{ value }} ne peut pas faire moins de {{ limit }} characters")
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @Assert\Email(message = "l adress mail {{ value }}  n'est pas valide .")
     * @Assert\NotBlank(message="Veuillez saisir votre email")
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Veuillez saisir nom de l'entreprise")
     * @ORM\Column(type="string", length=255)
     */
    private $nom_entreprise;

    /**
     * @Assert\NotBlank(message="Veuillez saisir site de l'entreprise ")
     * @ORM\Column(type="string", length=255)
     */
    private $site_entreprise;

    /**
     * @Assert\NotBlank(message="Veuillez saisir l'adresse")
     * @ORM\Column(type="string", length=255)
     */
    private $adresse_entreprise;

    /**
     * @Assert\Length(min=8 , max=8, minMessage=" votre numero {{ value }} doit etre {{ limit }} characters")
     * @Assert\NotBlank(message="Veuillez saisir votre numero de l'entrprise")
     * @ORM\Column(type="string", length=255)
     */
    private $num_employeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @Assert\NotBlank(message="Veuillez saisir description ")
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Veuillez  choisir le secteur")
     * @ORM\Column(type="string", length=255)
     */
    private $secteur;

    /**
     * @ORM\ManyToMany(targetEntity=Candidat::class, mappedBy="employeur")
     */
    private $candidats;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
        $this->nom_entreprise = $nom_entreprise;

        return $this;
    }

    public function getSiteEntreprise(): ?string
    {
        return $this->site_entreprise;
    }

    public function setSiteEntreprise(string $site_entreprise): self
    {
        $this->site_entreprise = $site_entreprise;

        return $this;
    }

    public function getAdresseEntreprise(): ?string
    {
        return $this->adresse_entreprise;
    }

    public function setAdresseEntreprise(string $adresse_entreprise): self
    {
        $this->adresse_entreprise = $adresse_entreprise;

        return $this;
    }

    public function getNumEmployeur(): ?string
    {
        return $this->num_employeur;
    }

    public function setNumEmployeur(string $num_employeur): self
    {
        $this->num_employeur = $num_employeur;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
            $candidat->addEmployeur($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidats->removeElement($candidat)) {
            $candidat->removeEmployeur($this);
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
