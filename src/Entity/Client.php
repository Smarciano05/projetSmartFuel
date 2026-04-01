<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    /**
     * @var Collection<int, Immatriculation>
     */
    #[ORM\OneToMany(targetEntity: Immatriculation::class, mappedBy: 'client')]
    private Collection $immatriculations;

    /**
     * @var Collection<int, EnregistrementEssence>
     */
    #[ORM\OneToMany(targetEntity: EnregistrementEssence::class, mappedBy: 'client')]
    private Collection $enregistrementEssences;

    public function __construct()
    {
        $this->immatriculations = new ArrayCollection();
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

    /**
     * @return Collection<int, Immatriculation>
     */
    public function getImmatriculations(): Collection
    {
        return $this->immatriculations;
    }

    public function addImmatriculation(Immatriculation $immatriculation): static
    {
        if (!$this->immatriculations->contains($immatriculation)) {
            $this->immatriculations->add($immatriculation);
            $immatriculation->setClient($this);
        }

        return $this;
    }

    public function removeImmatriculation(Immatriculation $immatriculation): static
    {
        if ($this->immatriculations->removeElement($immatriculation)) {
            // set the owning side to null (unless already changed)
            if ($immatriculation->getClient() === $this) {
                $immatriculation->setClient(null);
            }
        }

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
            $enregistrementEssence->setClient($this);
        }

        return $this;
    }

    public function removeEnregistrementEssence(EnregistrementEssence $enregistrementEssence): static
    {
        if ($this->enregistrementEssences->removeElement($enregistrementEssence)) {
            // set the owning side to null (unless already changed)
            if ($enregistrementEssence->getClient() === $this) {
                $enregistrementEssence->setClient(null);
            }
        }

        return $this;
    }
}
