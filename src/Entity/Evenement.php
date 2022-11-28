<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeEvenement $TypeEvenement = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enseignant $Enseignant = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hDeb = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hFin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEvmt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeEvenement(): ?TypeEvenement
    {
        return $this->TypeEvenement;
    }

    public function setTypeEvenement(?TypeEvenement $TypeEvenement): self
    {
        $this->TypeEvenement = $TypeEvenement;

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

    public function getHDeb(): ?\DateTimeInterface
    {
        return $this->hDeb;
    }

    public function setHDeb(\DateTimeInterface $hDeb): self
    {
        $this->hDeb = $hDeb;

        return $this;
    }

    public function getHFin(): ?\DateTimeInterface
    {
        return $this->hFin;
    }

    public function setHFin(\DateTimeInterface $hFin): self
    {
        $this->hFin = $hFin;

        return $this;
    }

    public function getDateEvmt(): ?\DateTimeInterface
    {
        return $this->dateEvmt;
    }

    public function setDateEvmt(\DateTimeInterface $dateEvmt): self
    {
        $this->dateEvmt = $dateEvmt;

        return $this;
    }
}