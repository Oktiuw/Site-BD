<?php

namespace App\Entity;

use App\Repository\TypeEvenementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeEvenementRepository::class)]
class TypeEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intTpEvmt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntTpEvmt(): ?string
    {
        return $this->intTpEvmt;
    }

    public function setIntTpEvmt(string $intTpEvmt): self
    {
        $this->intTpEvmt = $intTpEvmt;

        return $this;
    }
}
