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

    public function __construct()
    {
        $this->stages = new ArrayCollection();
        $this->groupeEtudiants = new ArrayCollection();
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
}
