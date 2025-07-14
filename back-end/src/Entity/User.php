<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message:'Cet email est déjà utilisé.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 75)]
    #[Assert\Regex(
        pattern: "/^[A-Za-z0-9_\-]+$/",
        message: "Le pseudo ne doit contenir que des lettres, chiffres, tirets ou underscores."
    )]
    private ?string $pseudo = null;

    #[ORM\Column(length: 75)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 75)]
    #[Assert\Regex(
        pattern: "/^[A-Za-zÀ-ÿ\- ]+$/u",
        message: "Le nom doit contenir uniquement des lettres, espaces ou tirets."
    )]
    private ?string $name = null;

    #[ORM\Column(length: 75)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 75)]
    #[Assert\Regex(
        pattern: "/^[A-Za-zÀ-ÿ\- ]+$/u",
        message: "Le prénom doit contenir uniquement des lettres, espaces ou tirets."
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 250, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(min: 5, max: 250)]
    private ?string $email = null;

    #[ORM\Column(length: 250)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 60, max: 250)] // hash bcrypt/argon
    private ?string $password = null;

    #[Assert\NotBlank(groups: ['registration'])]
    #[Assert\Length(min: 8, max: 100, groups: ['registration'])]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
        message: "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.",
        groups: ['registration']
    )]
    private ?string $plainPassword = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Dashboard $dashboard = null;

    #[ORM\OneToMany(targetEntity: Map::class, mappedBy: 'user')]
    private Collection $maps;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function __construct()
    {
        $this->maps = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getDashboard(): ?Dashboard
    {
        return $this->dashboard;
    }

    public function setDashboard(?Dashboard $dashboard): static
    {
        $this->dashboard = $dashboard;
        return $this;
    }

    /**
     * @return Collection<int, Map>
     */
    public function getMaps(): Collection
    {
        return $this->maps;
    }

    public function addMap(Map $map): static
    {
        if (!$this->maps->contains($map)) {
            $this->maps->add($map);
            $map->setUser($this);
        }
        return $this;
    }

    public function removeMap(Map $map): static
    {
        if ($this->maps->removeElement($map)) {
            if ($map->getUser() === $this) {
                $map->setUser(null);
            }
        }
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
}

