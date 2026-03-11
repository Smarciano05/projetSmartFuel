<?php

namespace App\Entity;

use App\Repository\PompisteRepository;
use BcMath\Number;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PompisteRepository::class)]
class Pompiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::NUMBER)]
    private ?Number $IDPompiste = null;

    #[ORM\Column(length: 255)]
    private ?string $NomPompiste = null;

    #[ORM\Column(length: 255)]
    private ?string $PrenomPompiste = null;

    #[ORM\Column(type: Types::NUMBER)]
    private ?Number $IDStation = null;

    #[ORM\Column(length: 255)]
    private ?string $NomStation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDPompiste(): ?Number
    {
        return $this->IDPompiste;
    }

    public function setIDPompiste(Number $IDPompiste): static
    {
        $this->IDPompiste = $IDPompiste;

        return $this;
    }

    public function getNomPompiste(): ?string
    {
        return $this->NomPompiste;
    }

    public function setNomPompiste(string $NomPompiste): static
    {
        $this->NomPompiste = $NomPompiste;

        return $this;
    }

    public function getPrenomPompiste(): ?string
    {
        return $this->PrenomPompiste;
    }

    public function setPrenomPompiste(string $PrenomPompiste): static
    {
        $this->PrenomPompiste = $PrenomPompiste;

        return $this;
    }

    public function getIDStation(): ?Number
    {
        return $this->IDStation;
    }

    public function setIDStation(Number $IDStation): static
    {
        $this->IDStation = $IDStation;

        return $this;
    }

    public function getNomStation(): ?string
    {
        return $this->NomStation;
    }

    public function setNomStation(string $NomStation): static
    {
        $this->NomStation = $NomStation;

        return $this;
    }
}
