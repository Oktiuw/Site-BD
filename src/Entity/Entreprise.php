<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
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

    #[ORM\OneToOne(inversedBy: 'entreprise', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $cdUtil = null;

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
}
