<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_Reclamation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Description est vide")
     */
    private $description_Reclamation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous n'avez pas choisi un type")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDateReclamation(): ?string
    {
        return $this->date_Reclamation;
    }

    public function setDateReclamation(string $date_Reclamation): self
    {
        $this->date_Reclamation = $date_Reclamation;

        return $this;
    }

    public function getDescriptionReclamation(): ?string
    {
        return $this->description_Reclamation;
    }

    public function setDescriptionReclamation(string $description_Reclamation): self
    {
        $this->description_Reclamation = $description_Reclamation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
