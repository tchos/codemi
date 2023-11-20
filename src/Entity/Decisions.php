<?php

namespace App\Entity;

use App\Repository\DecisionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: DecisionsRepository::class)]
#[UniqueEntity(
    fields: ['numeroDecision'],
    message: 'Cette décision existe déjà dans la base de données',
)]
class Decisions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/[0-9]*\/([A-Z0-9\/])+/',
        message: 'Mauvais format du numéro de décision',
    )]
    private ?string $numeroDecision = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSignature = null;

    #[ORM\Column(length: 64)]
    #[Assert\Regex(
        pattern: '/^([A-Z\s0-9\-])*$/',
        message: 'Le nom du signataire doit être en majuscule',
    )]
    private ?string $signataire = null;

    #[ORM\Column(length: 64)]
    private ?string $ministere = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(
        value: 1,
        message: 'Une décision doi avoir au moins 01 page'
    )]
    private ?int $nbrePages = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(
        value: 1,
        message: 'Une décision doi avoir au moins 01 agent invalide'
    )]
    private ?int $nbreAgentsInvalidesDecision = null;

    #[ORM\OneToMany(mappedBy: 'decision', targetEntity: Pages::class)]
    private Collection $pages;

    #[ORM\Column(length: 255)]
    private ?string $copie = null;

    #[ORM\ManyToOne(inversedBy: 'decisions')]
    private ?Utilisateurs $userDecision = null;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroDecision(): ?string
    {
        return $this->numeroDecision;
    }

    public function setNumeroDecision(string $numeroDecision): static
    {
        $this->numeroDecision = $numeroDecision;

        return $this;
    }

    public function getDateSignature(): ?\DateTimeInterface
    {
        return $this->dateSignature;
    }

    public function setDateSignature(\DateTimeInterface $dateSignature): static
    {
        $this->dateSignature = $dateSignature;

        return $this;
    }

    public function getSignataire(): ?string
    {
        return $this->signataire;
    }

    public function setSignataire(string $signataire): static
    {
        $this->signataire = $signataire;

        return $this;
    }

    public function getMinistere(): ?string
    {
        return $this->ministere;
    }

    public function setMinistere(string $ministere): static
    {
        $this->ministere = $ministere;

        return $this;
    }

    public function getNbrePages(): ?int
    {
        return $this->nbrePages;
    }

    public function setNbrePages(int $nbrePages): static
    {
        $this->nbrePages = $nbrePages;

        return $this;
    }

    public function getNbreAgentsInvalidesDecision(): ?int
    {
        return $this->nbreAgentsInvalidesDecision;
    }

    public function setNbreAgentsInvalidesDecision(int $nbreAgentsInvalidesDecision): static
    {
        $this->nbreAgentsInvalidesDecision = $nbreAgentsInvalidesDecision;

        return $this;
    }

    /**
     * @return Collection<int, Pages>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Pages $page): static
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
            $page->setDecision($this);
        }

        return $this;
    }

    public function removePage(Pages $page): static
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getDecision() === $this) {
                $page->setDecision(null);
            }
        }

        return $this;
    }

    public function getCopie(): ?string
    {
        return $this->copie;
    }

    public function setCopie(string $copie): static
    {
        $this->copie = $copie;

        return $this;
    }

    public function getUserDecision(): ?Utilisateurs
    {
        return $this->userDecision;
    }

    public function setUserDecision(?Utilisateurs $userDecision): static
    {
        $this->userDecision = $userDecision;

        return $this;
    }
}
