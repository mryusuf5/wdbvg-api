<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiProperty;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['place:read']],
    denormalizationContext: ['groups' => ['place:write']]
)]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['place:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['place:read', 'place:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['place:read', 'place:write'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['place:read', 'place:write'])]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['place:read', 'place:write'])]
    private ?string $latitude = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['place:read'])]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\OneToMany(mappedBy: 'place', targetEntity: Image::class)]
    #[Groups(['place:read'])]
    #[ApiProperty(readableLink: true)]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'place', targetEntity: Audio::class)]
    #[Groups(['place:read'])]
    #[ApiProperty(readableLink: true)]
    private Collection $audios;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->audios = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(?string $title): static { $this->title = $title; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }

    public function getLongitude(): ?string { return $this->longitude; }
    public function setLongitude(?string $longitude): static { $this->longitude = $longitude; return $this; }

    public function getLatitude(): ?string { return $this->latitude; }
    public function setLatitude(?string $latitude): static { $this->latitude = $latitude; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->created_at; }
    public function setCreatedAt(?\DateTimeImmutable $created_at): static { $this->created_at = $created_at; return $this; }

    /** @return Collection<int, Image> */
    public function getImages(): Collection { return $this->images; }

    /** @return Collection<int, Audio> */
    public function getAudios(): Collection { return $this->audios; }

    public function __toString(): string
    {
        return $this->title ?? '';
    }
}
