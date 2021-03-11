<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="la description d'offre ne peut pas être vide ")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le salaire d'offre ne peut pas être vide ")
     * @Assert\NotNull(message="le salaire ne doit pas être nulle")
     * @Assert\GreaterThan(0, message="salaire doit être positif")
     */
    private $salaire;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $dateDepo;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="la date d'expiration d'offre ne peut pas être vide ")
     * @Assert\GreaterThanOrEqual(
     *      value = "today",
     *      message = "date d'expiration invalide"
     * )
     */
    private $dateExpiration;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le nombre de place ne peut pas être vide ")
     * @Assert\NotNull(message="le nombre de place ne doit pas être nulle")
     * @Assert\GreaterThan(0, message="nombre de place doit être positif")
     */
    private $nombrePlace;


    /**
     * @ORM\JoinColumn(nullable=false)
     * @ORM\ManyToOne(targetEntity=Contrat::class, inversedBy="offres")
     * @Assert\NotBlank(message="le contrat ne peut pas être vide ")
     */
    private $contrat;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="la post ne peut pas être vide ")
     */
    private $post;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" objectif  ne peut pas être vide ")
     */
    private $objectif;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="les competences ne peuvent pas être vide ")
     */
    private $competences ;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="le domaine ne peut pas être vide ")
     */
    private $domaine;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="l'experience ne peut pas être vide ")
     * @Assert\GreaterThan(0, message="experience doit être positif")
     */
    private $experienceMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThan(0, message="experience doit être positif")
     */
    private $experienceMax;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $flagSupprimer;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $flagExpirer;

    /**
     * @ORM\OneToMany(targetEntity=Candidature::class, mappedBy="offre", orphanRemoval=true)
     */
    private $candidatures;



    public function __construct()
    {
        $this->dateDepo = new DateTime();
        $this->flagExpirer= false;
        $this->flagSupprimer= false;
        $this->candidatures = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getDateDepo(): ?DateTimeInterface
    {
        return $this->dateDepo;
    }

    public function setDateDepo(DateTimeInterface $dateDepo): self
    {
        $this->dateDepo = $dateDepo;

        return $this;
    }

    public function getDateExpiration(): ?DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(DateTimeInterface $dateExpiration): self
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getNombrePlace(): ?int
    {
        return $this->nombrePlace;
    }

    public function setNombrePlace(int $nombrePlace): self
    {
        $this->nombrePlace = $nombrePlace;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(?Contrat $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }


    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPost(): ?string
    {
        return $this->post;
    }

    public function setPost(string $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(string $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getCompetences(): ?string
    {
        return $this->competences;
    }

    public function setCompetences(string $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getExperienceMin(): ?int
    {
        return $this->experienceMin;
    }

    public function setExperienceMin(int $experienceMin): self
    {
        $this->experienceMin = $experienceMin;

        return $this;
    }

    public function getExperienceMax(): ?int
    {
        return $this->experienceMax;
    }

    public function setExperienceMax(int $experienceMax): self
    {
        $this->experienceMax = $experienceMax;

        return $this;
    }

    public function getFlagSupprimer(): ?bool
    {
        return $this->flagSupprimer;
    }

    public function setFlagSupprimer(?bool $flagSupprimer): self
    {
        $this->flagSupprimer = $flagSupprimer;

        return $this;
    }

    public function getFlagExpirer(): ?bool
    {
        return $this->flagExpirer;
    }

    public function setFlagExpirer(?bool $flagExpirer): self
    {
        $this->flagExpirer = $flagExpirer;

        return $this;
    }

    /**
     * @return Collection|Candidature[]
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setOffre($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getOffre() === $this) {
                $candidature->setOffre(null);
            }
        }

        return $this;
    }

}
