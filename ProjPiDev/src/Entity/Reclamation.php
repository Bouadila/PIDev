<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReclamationRepository::class)
 */
class Reclamation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"reclamation:get"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Titre est vide")
     * @Groups({"reclamation:get"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"reclamation:get"})
     */
    private $date_Reclamation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Description est vide")
     * @Groups({"reclamation:get"})
     */
    private $description_Reclamation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous n'avez pas choisi un type")
     * @Groups({"reclamation:get"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"reclamation:get"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"reclamation:get"})
     */
    private $status;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"reclamation:get"})
     */
    private $id_user;

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }



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

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
