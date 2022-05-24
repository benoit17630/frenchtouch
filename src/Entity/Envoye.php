<?php

namespace App\Entity;

use App\Repository\EnvoyeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnvoyeRepository::class)]
class Envoye
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float', nullable: true)]
    private $cash = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private $munition = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private $marchandise = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private $metal = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private $diamant = 0;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'envoyes')]
    private $user;

    #[ORM\ManyToOne(targetEntity: Stock::class, inversedBy: 'envoyes')]
    private $stock;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCash(): ?float
    {
        return $this->cash;
    }

    public function setCash(?float $cash): self
    {
        $this->cash = $cash;

        return $this;
    }

    public function getMunition(): ?float
    {
        return $this->munition;
    }

    public function setMunition(?float $munition): self
    {
        $this->munition = $munition;

        return $this;
    }

    public function getMarchandise(): ?float
    {
        return $this->marchandise;
    }

    public function setMarchandise(?float $machandise): self
    {
        $this->machandise = $machandise;

        return $this;
    }

    public function getMetal(): ?float
    {
        return $this->metal;
    }

    public function setMetal(?float $metal): self
    {
        $this->metal = $metal;

        return $this;
    }

    public function getDiamant(): ?float
    {
        return $this->diamant;
    }

    public function setDiamant(?float $diamant): self
    {
        $this->diamant = $diamant;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
