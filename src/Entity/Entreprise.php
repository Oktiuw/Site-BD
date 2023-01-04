<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEnt = null;

    #[ORM\Column(length: 255)]
    private ?string $nomRef = null;

    #[ORM\OneToOne(targetEntity: 'Utilisateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $cdUtil = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Stage::class, orphanRemoval: true)]
    private Collection $stages;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telEnt = null;

    #[ORM\Column]
    private ?bool $isDisabled = null;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnt(): ?string
    {
        return $this->nomEnt;
    }

    public function setNomEnt(string $nomEnt): self
    {
        $this->nomEnt = $nomEnt;

        return $this;
    }

    public function getNomRef(): ?string
    {
        return $this->nomRef;
    }

    public function setNomRef(string $nomRef): self
    {
        $this->nomRef = $nomRef;

        return $this;
    }

    public function getCdUtil(): ?Utilisateur
    {
        return $this->cdUtil;
    }

    public function setCdUtil(Utilisateur $cdUtil): self
    {
        $this->cdUtil = $cdUtil;

        return $this;
    }

    /**
     * @return Collection<int, Stage>
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages->add($stage);
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }

    public function getTelEnt(): ?string
    {
        return $this->telEnt;
    }

    public function setTelEnt(?string $telEnt): self
    {
        $this->telEnt = $telEnt;

        return $this;
    }

    public function isIsDisabled(): ?bool
    {
        return $this->isDisabled;
    }

    public function setIsDisabled(bool $isDisabled): self
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }
}
