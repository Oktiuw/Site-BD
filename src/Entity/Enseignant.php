<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
class Enseignant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numEn = null;

    #[ORM\Column(length: 100)]
    private ?string $nomEn = null;

    #[ORM\Column(length: 100)]
    private ?string $pnomEn = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dtnsEn = null;

    #[ORM\Column(length: 255)]
    private ?string $adEn = null;

    #[ORM\Column(length: 10)]
    private ?string $cpEn = null;

    #[ORM\Column(length: 150)]
    private ?string $villeEn = null;

    #[ORM\OneToOne(targetEntity: 'Utilisateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $cdUtil = null;

    #[ORM\OneToMany(mappedBy: 'Enseignant', targetEntity: Evenement::class, orphanRemoval: true)]
    private Collection $evenements;

    #[ORM\OneToMany(mappedBy: 'Enseignant', targetEntity: SujetTER::class, orphanRemoval: true)]
    private Collection $sujetTERs;

    #[ORM\Column]
    private ?bool $firstConnection = null;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
        $this->sujetTERs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumEn(): ?string
    {
        return $this->numEn;
    }

    public function setNumEn(string $numEn): self
    {
        $this->numEn = $numEn;

        return $this;
    }

    public function getNomEn(): ?string
    {
        return $this->nomEn;
    }

    public function setNomEn(string $nomEn): self
    {
        $this->nomEn = $nomEn;

        return $this;
    }

    public function getPnomEn(): ?string
    {
        return $this->pnomEn;
    }

    public function setPnomEn(string $pnomEn): self
    {
        $this->pnomEn = $pnomEn;

        return $this;
    }

    public function getDtnsEn(): ?\DateTimeInterface
    {
        return $this->dtnsEn;
    }

    public function setDtnsEn(\DateTimeInterface $dtnsEn): self
    {
        $this->dtnsEn = $dtnsEn;

        return $this;
    }

    public function getAdEn(): ?string
    {
        return $this->adEn;
    }

    public function setAdEn(string $adEn): self
    {
        $this->adEn = $adEn;

        return $this;
    }

    public function getCpEn(): ?string
    {
        return $this->cpEn;
    }

    public function setCpEn(string $cpEn): self
    {
        $this->cpEn = $cpEn;

        return $this;
    }

    public function getVilleEn(): ?string
    {
        return $this->villeEn;
    }

    public function setVilleEn(string $villeEn): self
    {
        $this->villeEn = $villeEn;

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
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setEnseignant($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getEnseignant() === $this) {
                $evenement->setEnseignant(null);
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
            $sujetTER->setEnseignant($this);
        }

        return $this;
    }

    public function removeSujetTER(SujetTER $sujetTER): self
    {
        if ($this->sujetTERs->removeElement($sujetTER)) {
            // set the owning side to null (unless already changed)
            if ($sujetTER->getEnseignant() === $this) {
                $sujetTER->setEnseignant(null);
            }
        }

        return $this;
    }
    public function isAdmin($result=null): bool
    {
        if ($this->getCdUtil()==null) {
            return false;
        }
        return $this->getCdUtil()->getRoles()[0]==='ROLE_ADMIN,ROLE_ENSEIGNANT';
    }

    public function isFirstConnection(): ?bool
    {
        return $this->firstConnection;
    }

    public function setFirstConnection(bool $firstConnection): self
    {
        $this->firstConnection = $firstConnection;

        return $this;
    }
}
