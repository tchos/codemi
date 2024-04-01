<?php

namespace App\Entity;

use App\Repository\AgentsInvalidesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentsInvalidesRepository::class)]
class AgentsInvalides
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 8, nullable: true)]
    private ?string $matriculeArmee = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $matriculeSolde = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $grade = null;

    #[ORM\Column(nullable: true)]
    private ?int $tauxInvalidite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateInvalidite = null;

    #[ORM\Column(nullable: true)]
    private ?int $rangInstance = null;

    #[ORM\Column(nullable: true)]
    private ?bool $revalorisation_y_n = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $typeAgent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $auteurInvalide = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDecesAuteur = null;

    #[ORM\Column(length: 16, nullable: true)]
    private ?string $typeInvalidite = null;

    #[ORM\Column(nullable: true)]
    private ?int $rangDecision = null;

    #[ORM\Column(nullable: true)]
    private ?int $rangPage = null;

    #[ORM\ManyToOne(inversedBy: 'agentsInvalides')]
    private ?Pages $page = null;

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

    public function getMatriculeArmee(): ?string
    {
        return $this->matriculeArmee;
    }

    public function setMatriculeArmee(?string $matriculeArmee): static
    {
        $this->matriculeArmee = $matriculeArmee;

        return $this;
    }

    public function getMatriculeSolde(): ?string
    {
        return $this->matriculeSolde;
    }

    public function setMatriculeSolde(?string $matriculeSolde): static
    {
        $this->matriculeSolde = $matriculeSolde;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getTauxInvalidite(): ?int
    {
        return $this->tauxInvalidite;
    }

    public function setTauxInvalidite(?int $tauxInvalidite): static
    {
        $this->tauxInvalidite = $tauxInvalidite;

        return $this;
    }

    public function getDateInvalidite(): ?\DateTimeInterface
    {
        return $this->dateInvalidite;
    }

    public function setDateInvalidite(?\DateTimeInterface $dateInvalidite): static
    {
        $this->dateInvalidite = $dateInvalidite;

        return $this;
    }

    public function getRangInstance(): ?int
    {
        return $this->rangInstance;
    }

    public function setRangInstance(?int $rangInstance): static
    {
        $this->rangInstance = $rangInstance;

        return $this;
    }

    public function isRevalorisationYN(): ?bool
    {
        return $this->revalorisation_y_n;
    }

    public function setRevalorisationYN(?bool $revalorisation_y_n): static
    {
        $this->revalorisation_y_n = $revalorisation_y_n;

        return $this;
    }

    public function getTypeAgent(): ?string
    {
        return $this->typeAgent;
    }

    public function setTypeAgent(?string $typeAgent): static
    {
        $this->typeAgent = $typeAgent;

        return $this;
    }

    public function getAuteurInvalide(): ?string
    {
        return $this->auteurInvalide;
    }

    public function setAuteurInvalide(?string $auteurInvalide): static
    {
        $this->auteurInvalide = $auteurInvalide;

        return $this;
    }

    public function getDateDecesAuteur(): ?\DateTimeInterface
    {
        return $this->dateDecesAuteur;
    }

    public function setDateDecesAuteur(?\DateTimeInterface $dateDecesAuteur): static
    {
        $this->dateDecesAuteur = $dateDecesAuteur;

        return $this;
    }

    public function getTypeInvalidite(): ?string
    {
        return $this->typeInvalidite;
    }

    public function setTypeInvalidite(?string $typeInvalidite): static
    {
        $this->typeInvalidite = $typeInvalidite;

        return $this;
    }

    public function getRangDecision(): ?int
    {
        return $this->rangDecision;
    }

    public function setRangDecision(?int $rangDecision): static
    {
        $this->rangDecision = $rangDecision;

        return $this;
    }

    public function getRangPage(): ?int
    {
        return $this->rangPage;
    }

    public function setRangPage(?int $rangPage): static
    {
        $this->rangPage = $rangPage;

        return $this;
    }

    public function getPage(): ?Pages
    {
        return $this->page;
    }

    public function setPage(?Pages $page): static
    {
        $this->page = $page;

        return $this;
    }
}
