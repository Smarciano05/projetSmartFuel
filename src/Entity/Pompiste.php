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

    #[ORM\Column(length: 255)]
    private ?string $NomPompiste = null;

    #[ORM\Column(length: 255)]
    private ?string $PrenomPompiste = null;

    #[ORM\ManyToOne(targetEntity: Stations::class, inversedBy: 'pompistes')]
    #[ORM\JoinColumn(name: 'IDStation', referencedColumnName: 'id', nullable: false)]
    private ?Stations $station = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getStation(): ?Stations
    {
        return $this->station;
    }

    public function setStation(?Stations $station): self
    {
        $this->station = $station;
        return $this;
    }
}
