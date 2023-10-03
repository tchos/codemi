<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateursRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['username'], message: 'Un utilisateur avec le username {{ value }} existe déjà !!!')]
class Utilisateurs implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $service = null;

    #[ORM\Column(length: 255)]
    private ?string $fullname = null;

    #[ORM\Column(length: 32)]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDernierConnexion = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'usersCrees')]
    private ?self $createdBy = null;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: self::class)]
    private Collection $usersCrees;

    #[ORM\Column]
    private ?bool $enable_y_n = null;

    public function __construct()
    {
        $this->usersCrees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
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
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): static
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * CallBack appelé à chaque fois que l'on veut enregistrer un user pour
     * prendre automatiquement sa date de création du compte .
     */
    #[ORM\PrePersist]
    public function PrePersist()
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTimeImmutable();
        }

        $this->dateDernierConnexion = new \DateTime();
    }

    /**
     * CallBack appelé à chaque fois que l'on veut mettre à jour un user pour
     * prendre automatiquement sa date de dernière visite du compte .
     */
    #[ORM\PreUpdate]
    public function  PreUpdate()
    {
        $this->dateDernierConnexion = new \DateTime();
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getDateDernierConnexion(): ?\DateTimeInterface
    {
        return $this->dateDernierConnexion;
    }

    public function setDateDernierConnexion(\DateTimeInterface $dateDernierConnexion): static
    {
        $this->dateDernierConnexion = new \DateTime();

        return $this;
    }

    public function getCreatedBy(): ?self
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?self $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUsersCrees(): Collection
    {
        return $this->usersCrees;
    }

    public function addUsersCree(self $usersCree): static
    {
        if (!$this->usersCrees->contains($usersCree)) {
            $this->usersCrees->add($usersCree);
            $usersCree->setCreatedBy($this);
        }

        return $this;
    }

    public function removeUsersCree(self $usersCree): static
    {
        if ($this->usersCrees->removeElement($usersCree)) {
            // set the owning side to null (unless already changed)
            if ($usersCree->getCreatedBy() === $this) {
                $usersCree->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function toString(): string {
        return $this->fullname;
    }

    public function isEnableYN(): ?bool
    {
        return $this->enable_y_n;
    }

    public function setEnableYN(bool $enable_y_n): static
    {
        $this->enable_y_n = $enable_y_n;

        return $this;
    }
}
