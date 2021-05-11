<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("candidature")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom est requis")
     * @Groups("candidature")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le prenom est requis")
     * @Groups("candidature")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("candidature")
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email is required")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     * @Groups("candidature")
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Groups("candidature")
     */
    private $date_naiss;

    /**
     * @ORM\Column(type="integer")
     * * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Votre numéro doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Votre numéro ne peut pas dépasser  {{ limit }} caractères"
     * )
     * @Assert\NotBlank(message="Le numéro est requis")
     * @Groups("candidature")
     */
    private $num;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("candidature")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("candidature")
     */
    private $diplome;

    /**
     * @ORM\Column(type="string", nullable=true)
     * Assert\Blank(message:"Télécharger votre cv svp")
     * Assert\File(mimeTypes={ "application/pdf" })
     * @Groups("candidature")
     */
    private $cv;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_candidat;


    /**
     * @ORM\OneToOne(targetEntity=Rendezvous::class, mappedBy="candidature", cascade={"persist", "remove"})
     */
    private $rendezvous;


    /**
     * @ORM\Column(type="datetime")
     * @Groups("candidature")
     */
    private $date_candidature;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="candidatures")
     */
    private $offre;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="candidatures")
     */
    private $candidat;

    
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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

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

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->date_naiss;
    }

    public function setDateNaiss(\DateTimeInterface $date_naiss): self
    {
        $this->date_naiss = $date_naiss;

        return $this;
    
    }

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

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

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getIdCandidat(): ?int
    {
        return $this->id_candidat;
    }

    public function setIdCandidat(?int $id_candidat): self
    {
        $this->id_candidat = $id_candidat;

        return $this;
    }

    public function getIdOffer(): ?int
    {
        return $this->id_offer;
    }

    public function setIdOffer(?int $id_offer): self
    {
        $this->id_offer = $id_offer;

        return $this;
    }

 

    public function getIdRdv(): ?int
    {
        return $this->id_rdv;
    }

    public function setIdRdv(?int $id_rdv): self
    {
        $this->id_rdv = $id_rdv;

        return $this;
    }

    public function getDateCandidature(): ?\DateTimeInterface
    {
        return $this->date_candidature;
    }

    public function setDateCandidature(\DateTimeInterface $date_candidature): self
    {
        $this->date_candidature = $date_candidature;

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

    public function getCandidat(): ?User
    {
        return $this->candidat;
    }

    public function setCandidat(?User $candidat): self
    {
        $this->candidat = $candidat;

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

}
