<?php

namespace App\Entity;

use App\Repository\CandidaterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidaterRepository::class)]
class Candidater
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $PJ = null;

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
}
