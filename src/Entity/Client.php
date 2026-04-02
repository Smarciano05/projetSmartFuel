<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

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


    #[ORM\Column(type: Types::INTEGER)]
    private ?int $numero = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
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
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
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
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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


    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

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
