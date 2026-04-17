<?php

namespace App\Entity;

use App\Repository\StockCarburantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockCarburantRepository::class)]
class StockCarburant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stockCarburants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Station $idStation = null;

    #[ORM\Column(length: 255)]
    private ?string $typeCarburant = null;

    #[ORM\Column]
    private ?float $qteCarburant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStation(): ?Station
    {
        return $this->idStation;
    }

    public function setIdStation(?Station $idStation): static
    {
        $this->idStation = $idStation;

        return $this;
    }

    public function getTypeCarburant(): ?string
    {
        return $this->typeCarburant;
    }

    public function setTypeCarburant(string $typeCarburant): static
    {
        $this->typeCarburant = $typeCarburant;

        return $this;
    }

    public function getQteCarburant(): ?float
    {
        return $this->qteCarburant;
    }

    public function setQteCarburant(float $qteCarburant): static
    {
        $this->qteCarburant = $qteCarburant;

        return $this;
    }

    public function ajouterQteCarburant(float $qteAAjouter): static
    {
        $this->qteCarburant += $qteAAjouter;
        return $this;
    }
}
