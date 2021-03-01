<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use DateTimeInterface;
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
     */
    private $dateExpiration;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="le nombre de place ne peut pas être vide ")
     * @Assert\NotNull(message="le nombre de place ne doit pas être nulle")
     */
    private $nombrePlace;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="l'experience ne peut pas être vide ")
     */
    private $experience;

    /**
     * @ORM\ManyToOne(targetEntity=Contrat::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contrat;

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

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

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
}
