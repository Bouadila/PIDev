<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Titre est vide")
     */
    private $TitreDemande;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Nom est vide")
     */
    private $nomCand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Prénom est vide")
     */
    private $prenomCand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Adresse mail est vide")
     */
    private $emailCand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Numéro est vide")
     * @Assert\Length( min=8 , max=8 , minMessage="Votre numéro doit comporter 8 chiffres" )
     */
    private $numCand;

    /**
     * @ORM\Column(type="text", length=255)
     * @Assert\NotBlank(message="Votre Adresse est vide")
     */
    private $adresseCand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez selectioner votre domaine")
     */
    private $domaineTravail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez selectioner votre statut")
     */
    private $statutCand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez faire une description")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez mettre votre cv")
     */
    private $cvCand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreDemande(): ?string
    {
        return $this->TitreDemande;
    }

    public function setTitreDemande(string $TitreDemande): self
    {
        $this->TitreDemande = $TitreDemande;

        return $this;
    }

    public function getNomCand(): ?string
    {
        return $this->nomCand;
    }

    public function setNomCand(string $nomCand): self
    {
        $this->nomCand = $nomCand;

        return $this;
    }

    public function getPrenomCand(): ?string
    {
        return $this->prenomCand;
    }

    public function setPrenomCand(string $prenomCand): self
    {
        $this->prenomCand = $prenomCand;

        return $this;
    }

    public function getEmailCand(): ?string
    {
        return $this->emailCand;
    }

    public function setEmailCand(string $emailCand): self
    {
        $this->emailCand = $emailCand;

        return $this;
    }

    public function getNumCand(): ?string
    {
        return $this->numCand;
    }

    public function setNumCand(string $numCand): self
    {
        $this->numCand = $numCand;

        return $this;
    }

    public function getAdresseCand(): ?string
    {
        return $this->adresseCand;
    }

    public function setAdresseCand(string $adresseCand): self
    {
        $this->adresseCand = $adresseCand;

        return $this;
    }

    public function getDomaineTravail(): ?string
    {
        return $this->domaineTravail;
    }

    public function setDomaineTravail(string $domaineTravail): self
    {
        $this->domaineTravail = $domaineTravail;

        return $this;
    }

    public function getStatutCand(): ?string
    {
        return $this->statutCand;
    }

    public function setStatutCand(string $statutCand): self
    {
        $this->statutCand = $statutCand;

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

    public function getCvCand(): ?string
    {
        return $this->cvCand;
    }

    public function setCvCand(string $cvCand): self
    {
        $this->cvCand = $cvCand;

        return $this;
    }
}
