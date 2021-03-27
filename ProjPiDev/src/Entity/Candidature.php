<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datePostuler;

    /**
     * @ORM\Column(type="integer")
     */
    private $noteQuiz;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidat;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="candidatures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offre;

    /**
     * @ORM\OneToOne(targetEntity=Rendezvous::class, mappedBy="candidature", cascade={"persist", "remove"})
     */
    private $rendezvous;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $titre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePostuler(): ?\DateTimeInterface
    {
        return $this->datePostuler;
    }

    public function setDatePostuler(\DateTimeInterface $datePostuler): self
    {
        $this->datePostuler = $datePostuler;

        return $this;
    }

    public function getNoteQuiz(): ?int
    {
        return $this->noteQuiz;
    }

    public function setNoteQuiz(int $noteQuiz): self
    {
        $this->noteQuiz = $noteQuiz;

        return $this;
    }

    public function getCandidat(): ?User
    {
        return $this->candidat;
    }

    public function setCandidat(?User $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getRendezvous(): ?Rendezvous
    {
        return $this->rendezvous;
    }

    public function setRendezvous(Rendezvous $rendezvous): self
    {
        // set the owning side of the relation if necessary
        if ($rendezvous->getCandidature() !== $this) {
            $rendezvous->setCandidature($this);
        }

        $this->rendezvous = $rendezvous;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}
