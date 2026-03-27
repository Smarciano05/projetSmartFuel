<?php

namespace App\Entity;

use App\Repository\PompisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
// Imports nécessaires pour la sécurité
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: PompisteRepository::class)]
class Pompiste implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180, unique: true)] // Ajout de l'unique pour la sécurité
    private ?string $email = null;

    // 1. AJOUT DU CHAMP ROLES (Obligatoire pour UserInterface)
    #[ORM\Column]
    private array $roles = [];

    // 2. AJOUT DU CHAMP PASSWORD (Obligatoire pour PasswordAuthenticatedUserInterface)
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'pompistes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Station $station = null;

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

    // --- MÉTHODES OBLIGATOIRES POUR USERINTERFACE ---

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // On garantit que chaque utilisateur possède au moins le rôle ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // Si tu as des données sensibles temporaires, efface-les ici
    }

    // --- TES AUTRES GETTERS / SETTERS ---

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
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

    public function getEnregistrementEssences(): Collection
    {
        return $this->enregistrementEssences;
    }
}