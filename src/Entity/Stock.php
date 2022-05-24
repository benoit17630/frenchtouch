<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'stock', targetEntity: Don::class)]
    private $dons;

    #[ORM\OneToMany(mappedBy: 'stock', targetEntity: Envoye::class)]
    private $envoyes;

    public function __construct()
    {
        $this->dons = new ArrayCollection();
        $this->envoyes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Don>
     */
    public function getDons(): Collection
    {
        return $this->dons;
    }

    public function addDon(Don $don): self
    {
        if (!$this->dons->contains($don)) {
            $this->dons[] = $don;
            $don->setStock($this);
        }

        return $this;
    }

    public function removeDon(Don $don): self
    {
        if ($this->dons->removeElement($don)) {
            // set the owning side to null (unless already changed)
            if ($don->getStock() === $this) {
                $don->setStock(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Envoye>
     */
    public function getEnvoyes(): Collection
    {
        return $this->envoyes;
    }

    public function addEnvoye(Envoye $envoye): self
    {
        if (!$this->envoyes->contains($envoye)) {
            $this->envoyes[] = $envoye;
            $envoye->setStock($this);
        }

        return $this;
    }

    public function removeEnvoye(Envoye $envoye): self
    {
        if ($this->envoyes->removeElement($envoye)) {
            // set the owning side to null (unless already changed)
            if ($envoye->getStock() === $this) {
                $envoye->setStock(null);
            }
        }

        return $this;
    }
}
