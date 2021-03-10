<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("post:read")
     */
    private $TitreDemande;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("post:read")
     */

    private $domaineTravail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("post:read")
     */
    private $statutCand;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("post:read")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups("post:read")
     */
    private $cvCand;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("post:read")
     */
    private $idCand;

    public function __construct()
    {
        $this->id_cand = new ArrayCollection();
    }



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

    /**
     * @return Collection|User[]
     */
    public function getIdCand(): Collection
    {
        return $this->id_cand;
    }

    public function addIdCand(User $idCand): self
    {
        if (!$this->id_cand->contains($idCand)) {
            $this->id_cand[] = $idCand;
            $idCand->setDemande($this);
        }

        return $this;
    }

    public function removeIdCand(User $idCand): self
    {
        if ($this->id_cand->removeElement($idCand)) {
            // set the owning side to null (unless already changed)
            if ($idCand->getDemande() === $this) {
                $idCand->setDemande(null);
            }
        }

        return $this;
    }

    public function setIdCand(?User $idCand): self
    {
        $this->idCand = $idCand;

        return $this;
    }

}
