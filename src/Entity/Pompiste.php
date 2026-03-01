<?php

namespace App\Entity;

use App\Repository\PompisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PompisteRepository::class)]
class Pompiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'pompistes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Station $station = null;

    /**
     * @var Collection<int, EnregistrementEssence>
     */
    #[ORM\OneToMany(targetEntity: EnregistrementEssence::class, mappedBy: 'pompiste')]
    private Collection $enregistrementEssences;

    public function __construct()
    {
        $this->enregistrementEssences = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): static
    {
        $this->station = $station;

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
            $enregistrementEssence->setPompiste($this);
        }

        return $this;
    }

    public function removeEnregistrementEssence(EnregistrementEssence $enregistrementEssence): static
    {
        if ($this->enregistrementEssences->removeElement($enregistrementEssence)) {
            // set the owning side to null (unless already changed)
            if ($enregistrementEssence->getPompiste() === $this) {
                $enregistrementEssence->setPompiste(null);
            }
        }

        return $this;
    }


}
