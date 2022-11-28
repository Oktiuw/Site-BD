<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $numEtud = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $cvEtud = null;

    #[ORM\Column(length: 100)]
    private ?string $nomEtud = null;

    #[ORM\Column(length: 100)]
    private ?string $pnomEtud = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dtnsEtud = null;

    #[ORM\Column(length: 255)]
    private ?string $adEtud = null;

    #[ORM\Column(length: 10)]
    private ?string $cpEtud = null;

    #[ORM\Column(length: 150)]
    private ?string $villeEtud = null;

    #[ORM\OneToOne(inversedBy: 'etudiant', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $cdUtil = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumEtud(): ?string
    {
        return $this->numEtud;
    }

    public function setNumEtud(string $numEtud): self
    {
        $this->numEtud = $numEtud;

        return $this;
    }

    public function getCvEtud()
    {
        return $this->cvEtud;
    }

    public function setCvEtud($cvEtud): self
    {
        $this->cvEtud = $cvEtud;

        return $this;
    }

    public function getNomEtud(): ?string
    {
        return $this->nomEtud;
    }

    public function setNomEtud(string $nomEtud): self
    {
        $this->nomEtud = $nomEtud;

        return $this;
    }

    public function getPnomEtud(): ?string
    {
        return $this->pnomEtud;
    }

    public function setPnomEtud(string $pnomEtud): self
    {
        $this->pnomEtud = $pnomEtud;

        return $this;
    }

    public function getDtnsEtud(): ?\DateTimeInterface
    {
        return $this->dtnsEtud;
    }

    public function setDtnsEtud(\DateTimeInterface $dtnsEtud): self
    {
        $this->dtnsEtud = $dtnsEtud;

        return $this;
    }

    public function getAdEtud(): ?string
    {
        return $this->adEtud;
    }

    public function setAdEtud(string $adEtud): self
    {
        $this->adEtud = $adEtud;

        return $this;
    }

    public function getCpEtud(): ?string
    {
        return $this->cpEtud;
    }

    public function setCpEtud(string $cpEtud): self
    {
        $this->cpEtud = $cpEtud;

        return $this;
    }

    public function getVilleEtud(): ?string
    {
        return $this->villeEtud;
    }

    public function setVilleEtud(string $villeEtud): self
    {
        $this->villeEtud = $villeEtud;

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
