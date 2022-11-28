<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titreStage = null;

    #[ORM\Column(length: 255)]
    private ?string $adStage = null;

    #[ORM\Column(length: 255)]
    private ?string $cpStage = null;

    #[ORM\Column(length: 255)]
    private ?string $villeStage = null;

    #[ORM\Column(length: 9999)]
    private ?string $descStage = null;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne(inversedBy: 'stages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveau $niveau = null;

    #[ORM\OneToMany(mappedBy: 'stage', targetEntity: Canditatures::class, orphanRemoval: true)]
    private Collection $canditatures;

    public function __construct()
    {
        $this->canditatures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreStage(): ?string
    {
        return $this->titreStage;
    }

    public function setTitreStage(string $titreStage): self
    {
        $this->titreStage = $titreStage;

        return $this;
    }

    public function getAdStage(): ?string
    {
        return $this->adStage;
    }

    public function setAdStage(string $adStage): self
    {
        $this->adStage = $adStage;

        return $this;
    }

    public function getCpStage(): ?string
    {
        return $this->cpStage;
    }

    public function setCpStage(string $cpStage): self
    {
        $this->cpStage = $cpStage;

        return $this;
    }

    public function getVilleStage(): ?string
    {
        return $this->villeStage;
    }

    public function setVilleStage(string $villeStage): self
    {
        $this->villeStage = $villeStage;

        return $this;
    }

    public function getDescStage(): ?string
    {
        return $this->descStage;
    }

    public function setDescStage(string $descStage): self
    {
        $this->descStage = $descStage;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, Canditatures>
     */
    public function getCanditatures(): Collection
    {
        return $this->canditatures;
    }

    public function addCanditature(Canditatures $canditature): self
    {
        if (!$this->canditatures->contains($canditature)) {
            $this->canditatures->add($canditature);
            $canditature->setStage($this);
        }

        return $this;
    }

    public function removeCanditature(Canditatures $canditature): self
    {
        if ($this->canditatures->removeElement($canditature)) {
            // set the owning side to null (unless already changed)
            if ($canditature->getStage() === $this) {
                $canditature->setStage(null);
            }
        }

        return $this;
    }
}
