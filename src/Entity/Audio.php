<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AudioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AudioRepository::class)]
#[ApiResource]
class Audio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['place:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['place:read'])]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    #[Groups(['place:read'])]
    private ?string $title = null;

    // IMPORTANT: inversedBy must match Place::$audios
    #[ORM\ManyToOne(targetEntity: Place::class, inversedBy: 'audios')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
    private ?Place $place = null;

    // Not persisted, not serialized
    private ?UploadedFile $file = null;

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

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): static
    {
        $this->place = $place;
        return $this;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(?UploadedFile $file): static
    {
        $this->file = $file;
        return $this;
    }
}
