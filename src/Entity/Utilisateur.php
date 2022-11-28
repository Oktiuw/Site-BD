<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $mdp = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $login = null;

    #[ORM\OneToOne(mappedBy: 'cdUtil', cascade: ['persist', 'remove'])]
    private ?Etudiant $etudiant = null;

    #[ORM\OneToOne(mappedBy: 'cdUtil', cascade: ['persist', 'remove'])]
    private ?Enseignant $enseignant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(Etudiant $etudiant): self
    {
        // set the owning side of the relation if necessary
        if ($etudiant->getCdUtil() !== $this) {
            $etudiant->setCdUtil($this);
        }

        $this->etudiant = $etudiant;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(Enseignant $enseignant): self
    {
        // set the owning side of the relation if necessary
        if ($enseignant->getCdUtil() !== $this) {
            $enseignant->setCdUtil($this);
        }

        $this->enseignant = $enseignant;

        return $this;
    }
}
