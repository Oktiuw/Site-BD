<?php

namespace App\Entity;

use App\Repository\SujetTERRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SujetTERRepository::class)]
class SujetTER
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titreTer = null;

    #[ORM\Column(length: 9999)]
    private ?string $descTer = null;

    #[ORM\ManyToOne(inversedBy: 'sujetTERs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Niveau $niveau = null;

    #[ORM\ManyToOne(inversedBy: 'sujetTERs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enseignant $Enseignant = null;

    #[ORM\ManyToOne(inversedBy: 'sujetTERs')]
    private ?Etudiant $Etudiant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreTer(): ?string
    {
        return $this->titreTer;
    }

    public function setTitreTer(string $titreTer): self
    {
        $this->titreTer = $titreTer;

        return $this;
    }

    public function getDescTer(): ?string
    {
        return $this->descTer;
    }

    public function setDescTer(string $descTer): self
    {
        $this->descTer = $descTer;

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

    public function getEnseignant(): ?Enseignant
    {
        return $this->Enseignant;
    }

    public function setEnseignant(?Enseignant $Enseignant): self
    {
        $this->Enseignant = $Enseignant;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->Etudiant;
    }

    public function setEtudiant(?Etudiant $Etudiant): self
    {
        $this->Etudiant = $Etudiant;

        return $this;
    }
}
