<?php

namespace App\Entity;
use App\Repository\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraint\Email;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @ORM\Table(name="candidat")
 * @ORM\Entity(repositoryClass=CandidatRepository::class)
 *
 */
class Candidat
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
     * @Assert\Email(message = "l adress mail'{{ value }}' n'est pas valide .")
     * @Assert\NotBlank(message="Veuillez saisir votre email")
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     *@Assert\NotBlank(message="Veuillez saisir votre sexe")
     * @ORM\Column(type="string", length=64 )
     */
    private $genre;


    /**
     * @Assert\NotBlank(message="Veuillez saisir votre mdp ")
     * @Assert\Length(min=2 , minMessage="votre mdp {{ value }} ne peut pas faire moins de {{ limit }} characters")
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre gover")
     * @ORM\Column(type="string", length=255)
     */
    private $gover;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @Assert\Length(min=8 , max=8, minMessage=" votre numero {{ value }} doit etre {{ limit }} characters")
     * @Assert\NotBlank(message="Veuillez saisir votre numero")
     * @ORM\Column(type="string", length=255)
     */
    private $num;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre specialite")
     * @ORM\Column(type="string", length=255)
     */
    private $special;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre diplome")
     * @ORM\Column(type="string", length=255)
     */
    private $diplome;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre cv")
     * @ORM\Column(type="string", length=255)
     */
    private $cv;

    /**
     * @ORM\ManyToMany(targetEntity=Employeur::class, inversedBy="candidats")
     */
    private $employeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @Assert\NotBlank(message="Veuillez saisir votre date de naissance")
     * @ORM\Column(type="date")
     */
    private $date_naisse;

    public function __construct()
    {
        $this->employeur = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

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

    public function getGover(): ?string
    {
        return $this->gover;
    }

    public function setGover(string $gover): self
    {
        $this->gover = $gover;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg( $img)
    {
        $this->img = $img;

        return $this;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(string $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getSpecial(): ?string
    {
        return $this->special;
    }

    public function setSpecial(string $special): self
    {
        $this->special = $special;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * @return Collection|Employeur[]
     */
    public function getEmployeur(): Collection
    {
        return $this->employeur;
    }

    public function addEmployeur(Employeur $employeur): self
    {
        if (!$this->employeur->contains($employeur)) {
            $this->employeur[] = $employeur;
        }

        return $this;
    }

    public function removeEmployeur(Employeur $employeur): self
    {
        $this->employeur->removeElement($employeur);

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

    public function getDateNaisse(): ?\DateTimeInterface
    {
        return $this->date_naisse;
    }

    public function setDateNaisse(\DateTimeInterface $date_naisse): self
    {
        $this->date_naisse = $date_naisse;

        return $this;
    }
}
