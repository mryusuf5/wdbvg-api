<?php

namespace App\Entity;

use App\Repository\UserPlaceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPlaceRepository::class)]
class UserPlace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column]
    private ?int $place_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPlaceId(): ?int
    {
        return $this->place_id;
    }

    public function setPlaceId(int $place_id): static
    {
        $this->place_id = $place_id;

        return $this;
    }
}
