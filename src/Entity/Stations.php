<?php

namespace App\Entity;

use App\Repository\StationsRepository;
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
}
