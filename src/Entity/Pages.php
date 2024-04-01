<?php

namespace App\Entity;

use App\Repository\PagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagesRepository::class)]
class Pages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    private ?string $numeroPage = null;

    #[ORM\Column]
    private ?int $nbreAgentsInvalidesPage = null;

    #[ORM\ManyToOne(inversedBy: 'pages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Decisions $decision = null;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: AgentsInvalides::class)]
    private Collection $agentsInvalides;

    public function __construct()
    {
        $this->agentsInvalides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroPage(): ?string
    {
        return $this->numeroPage;
    }

    public function setNumeroPage(string $numeroPage): static
    {
        $this->numeroPage = $numeroPage;

        return $this;
    }

    public function getNbreAgentsInvalidesPage(): ?int
    {
        return $this->nbreAgentsInvalidesPage;
    }

    public function setNbreAgentsInvalidesPage(int $nbreAgentsInvalidesPage): static
    {
        $this->nbreAgentsInvalidesPage = $nbreAgentsInvalidesPage;

        return $this;
    }

    public function getDecision(): ?Decisions
    {
        return $this->decision;
    }

    public function setDecision(?Decisions $decision): static
    {
        $this->decision = $decision;

        return $this;
    }

    /**
     * @return Collection<int, AgentsInvalides>
     */
    public function getAgentsInvalides(): Collection
    {
        return $this->agentsInvalides;
    }

    public function addAgentsInvalide(AgentsInvalides $agentsInvalide): static
    {
        if (!$this->agentsInvalides->contains($agentsInvalide)) {
            $this->agentsInvalides->add($agentsInvalide);
            $agentsInvalide->setPage($this);
        }

        return $this;
    }

    public function removeAgentsInvalide(AgentsInvalides $agentsInvalide): static
    {
        if ($this->agentsInvalides->removeElement($agentsInvalide)) {
            // set the owning side to null (unless already changed)
            if ($agentsInvalide->getPage() === $this) {
                $agentsInvalide->setPage(null);
            }
        }

        return $this;
    }
}
