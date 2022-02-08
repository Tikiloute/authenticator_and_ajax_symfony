<?php

namespace App\Entity;

use App\Repository\AlimentLikeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlimentLikeRepository::class)]
class AlimentLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Aliment::class, inversedBy: 'likes')]
    private $aliment;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'likes')]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAliment(): ?Aliment
    {
        return $this->aliment;
    }

    public function setAliment(?Aliment $aliment): self
    {
        $this->aliment = $aliment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
