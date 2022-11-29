<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libRole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibRole(): ?string
    {
        return $this->libRole;
    }

    public function setLibRole(string $libRole): self
    {
        $this->libRole = $libRole;

        return $this;
    }
}
