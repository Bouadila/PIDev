<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_offer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $offer_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOffer(): ?string
    {
        return $this->nom_offer;
    }

    public function setNomOffer(string $nom_offer): self
    {
        $this->nom_offer = $nom_offer;

        return $this;
    }

    public function getOfferDate(): ?string
    {
        return $this->offer_date;
    }

    public function setOfferDate(?string $offer_date): self
    {
        $this->offer_date = $offer_date;

        return $this;
    }
}
