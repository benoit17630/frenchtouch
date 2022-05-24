<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $cash = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $munition = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $marchandise = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $metal = 0;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $diamant = 0;

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

    public function setMarchandise(?float $marchandise): self
    {
        $this->marchandise = $marchandise;

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
}
