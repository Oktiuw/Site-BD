<?php

namespace App\Entity;

use App\Repository\CanditaturesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CanditaturesRepository::class)]
class Candidatures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $PJ = null;

    #[ORM\ManyToOne(inversedBy: 'canditatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne(inversedBy: 'canditatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPJ()
    {
        return $this->PJ;
    }

    public function setPJ($PJ): self
    {
        $this->PJ = $PJ;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): self
    {
        $this->stage = $stage;

        return $this;
    }
}
