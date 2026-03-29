<?php

namespace App\Entity;

use App\Repository\ImmatriculationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImmatriculationRepository::class)]
class Immatriculation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ? Number $numero = null;

    #[ORM\ManyToOne(inversedBy: 'immatriculations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    /**
     * @var Collection<int, EnregistrementEssence>
     */
    #[ORM\OneToMany(targetEntity: EnregistrementEssence::class, mappedBy: 'immatriculation')]
    private Collection $enregistrementEssences;

    public function __construct()
    {
        $this->enregistrementEssences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?Number
    {
        return $this->numero;
    }

    public function setNumero(Number $numero): static
    {
        $this->numero = $numero;

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

    /**
     * @return Collection<int, EnregistrementEssence>
     */
    public function getEnregistrementEssences(): Collection
    {
        return $this->enregistrementEssences;
    }

    public function addEnregistrementEssence(EnregistrementEssence $enregistrementEssence): static
    {
        if (!$this->enregistrementEssences->contains($enregistrementEssence)) {
            $this->enregistrementEssences->add($enregistrementEssence);
            $enregistrementEssence->setImmatriculation($this);
        }

        return $this;
    }

    public function removeEnregistrementEssence(EnregistrementEssence $enregistrementEssence): static
    {
        if ($this->enregistrementEssences->removeElement($enregistrementEssence)) {
            // set the owning side to null (unless already changed)
            if ($enregistrementEssence->getImmatriculation() === $this) {
                $enregistrementEssence->setImmatriculation(null);
            }
        }

        return $this;
    }
}
