<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Pompiste>
     */
    #[ORM\OneToMany(targetEntity: Pompiste::class, mappedBy: 'Station', orphanRemoval: true)]
    private Collection $pompistes;

     /**
     * @var Collection<int, EnregistrementEssence>
     */
    #[ORM\OneToMany(targetEntity: EnregistrementEssence::class, mappedBy: 'station')]
    private Collection $enregistrementEssences;

    /**
     * @var Collection<int, StockCarburant>
     */
    #[ORM\OneToMany(targetEntity: StockCarburant::class, mappedBy: 'idStation', orphanRemoval: true)]
    private Collection $stockCarburants;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;


    public function __construct()
    {
        $this->pompistes = new ArrayCollection();
        $this->stockCarburants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Pompiste>
     */
    public function getPompistes(): Collection
    {
        return $this->pompistes;
    }

    public function addPompiste(Pompiste $pompiste): static
    {
        if (!$this->pompistes->contains($pompiste)) {
            $this->pompistes->add($pompiste);
            $pompiste->setStation($this);
        }

        return $this;
    }

    public function removePompiste(Pompiste $pompiste): static
    {
        if ($this->pompistes->removeElement($pompiste)) {
            // set the owning side to null (unless already changed)
            if ($pompiste->getStation() === $this) {
                $pompiste->setStation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StockCarburant>
     */
    public function getStockCarburants(): Collection
    {
        return $this->stockCarburants;
    }

    public function addStockCarburant(StockCarburant $stockCarburant): static
    {
        if (!$this->stockCarburants->contains($stockCarburant)) {
            $this->stockCarburants->add($stockCarburant);
            $stockCarburant->setIdStation($this);
        }

        return $this;
    }

    public function removeStockCarburant(StockCarburant $stockCarburant): static
    {
        if ($this->stockCarburants->removeElement($stockCarburant)) {
            // set the owning side to null (unless already changed)
            if ($stockCarburant->getIdStation() === $this) {
                $stockCarburant->setIdStation(null);
            }
        }

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }
}
