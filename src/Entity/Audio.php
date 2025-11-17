<?php

namespace App\Entity;

use App\Repository\AudioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudioRepository::class)]
class Audio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $place_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPlaceId(): ?int
    {
        return $this->place_id;
    }

    public function setPlaceId(?int $place_id): static
    {
        $this->place_id = $place_id;

        return $this;
    }
}
