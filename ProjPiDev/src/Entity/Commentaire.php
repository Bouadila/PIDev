<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Description;

    /**
     * @ORM\Column(type="integer")
     */
    private $NbrReac;

    /**
     * @ORM\ManyToOne(targetEntity=Annonce::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $TimeStamp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getNbrReac(): ?int
    {
        return $this->NbrReac;
    }

    public function setNbrReac(int $NbrReac): self
    {
        $this->NbrReac = $NbrReac;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getTimeStamp(): ?string
    {
        return $this->TimeStamp;
    }

    public function setTimeStamp(string $TimeStamp): self
    {
        $this->TimeStamp = $TimeStamp;

        return $this;
    }
}
