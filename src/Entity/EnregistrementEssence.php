<?php

namespace App\Entity;

use App\Repository\EnregistrementEssenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnregistrementEssenceRepository::class)]
class EnregistrementEssence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    private ?string $type_carburant = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'enregistrementEssences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pompiste $pompiste = null;

    #[ORM\ManyToOne(inversedBy: 'enregistrementEssences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'enregistrementEssences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stations $Stations = null;

    #[ORM\ManyToOne(inversedBy: 'enregistrementEssences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Immatriculation $immatriculation = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCarburant(): ?string
    {
        return $this->type_carburant;
    }

    public function setTypeCarburant(string $type_carburant): static
    {
        $this->type_carburant = $type_carburant;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPompiste(): ?Pompiste
    {
        return $this->pompiste;
    }

    public function setPompiste(?Pompiste $pompiste): static
    {
        $this->pompiste = $pompiste;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getStations(): ?Stations
    {
        return $this->Stations;
    }

    public function setStations(?Stations $Stations): static
    {
        $this->Stations = $Stations;

        return $this;
    }

    public function getImmatriculation(): ?Immatriculation
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?Immatriculation $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }
}
