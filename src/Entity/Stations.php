<?php

namespace App\Entity;

use App\Repository\StationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationsRepository::class)]
class Stations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $nomVille = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $litreEssence = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $litreDiesel = null;

    /**
     * @var Collection<int, Pompiste>
     */
    #[ORM\OneToMany(targetEntity: Pompiste::class, mappedBy: 'Stations', orphanRemoval: true)]
    private Collection $pompistes;

    public function __construct()
    {
        $this->pompistes = new ArrayCollection();
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

    public function getNomVille(): ?string
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): static
    {
        $this->nomVille = $nomVille;

        return $this;
    }

    public function getLitreEssence(): ?string
    {
        return $this->litreEssence;
    }

    public function setLitreEssence(string $litreEssence): static
    {
        $this->litreEssence = $litreEssence;

        return $this;
    }

    public function getLitreDiesel(): ?string
    {
        return $this->litreDiesel;
    }

    public function setLitreDiesel(string $litreDiesel): static
    {
        $this->litreDiesel = $litreDiesel;

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
            $pompiste->setStations($this);
        }

        return $this;
    }

    public function removePompiste(Pompiste $pompiste): static
    {
        if ($this->pompistes->removeElement($pompiste)) {
            // set the owning side to null (unless already changed)
            if ($pompiste->getStations() === $this) {
                $pompiste->setStations(null);
            }
        }

        return $this;
    }
}
