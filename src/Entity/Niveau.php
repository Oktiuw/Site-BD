<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libNiv = null;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Stage::class, orphanRemoval: true)]
    private Collection $stages;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: GroupeEtudiants::class, orphanRemoval: true)]
    private Collection $groupeEtudiants;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: SujetTER::class, orphanRemoval: true)]
    private Collection $sujetTERs;

    #[ORM\OneToMany(mappedBy: 'niveau', targetEntity: Etudiant::class)]
    private Collection $etudiants;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
        $this->groupeEtudiants = new ArrayCollection();
        $this->sujetTERs = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibNiv(): ?string
    {
        return $this->libNiv;
    }

    public function setLibNiv(string $libNiv): self
    {
        $this->libNiv = $libNiv;

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
            $stage->setNiveau($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getNiveau() === $this) {
                $stage->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupeEtudiants>
     */
    public function getGroupeEtudiants(): Collection
    {
        return $this->groupeEtudiants;
    }

    public function addGroupeEtudiant(GroupeEtudiants $groupeEtudiant): self
    {
        if (!$this->groupeEtudiants->contains($groupeEtudiant)) {
            $this->groupeEtudiants->add($groupeEtudiant);
            $groupeEtudiant->setNiveau($this);
        }

        return $this;
    }

    public function removeGroupeEtudiant(GroupeEtudiants $groupeEtudiant): self
    {
        if ($this->groupeEtudiants->removeElement($groupeEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($groupeEtudiant->getNiveau() === $this) {
                $groupeEtudiant->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SujetTER>
     */
    public function getSujetTERs(): Collection
    {
        return $this->sujetTERs;
    }

    public function addSujetTER(SujetTER $sujetTER): self
    {
        if (!$this->sujetTERs->contains($sujetTER)) {
            $this->sujetTERs->add($sujetTER);
            $sujetTER->setNiveau($this);
        }

        return $this;
    }

    public function removeSujetTER(SujetTER $sujetTER): self
    {
        if ($this->sujetTERs->removeElement($sujetTER)) {
            // set the owning side to null (unless already changed)
            if ($sujetTER->getNiveau() === $this) {
                $sujetTER->setNiveau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
            $etudiant->setNiveau($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getNiveau() === $this) {
                $etudiant->setNiveau(null);
            }
        }

        return $this;
    }
}
