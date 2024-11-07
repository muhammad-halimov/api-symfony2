<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\TerminalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TerminalRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Patch(),
    ],
    normalizationContext: ['groups' => ['terminal:read']],
    paginationEnabled: false,
)]
#[ORM\HasLifecycleCallbacks]
class Terminal
{
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['terminal:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['terminal:read'])]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['terminal:read'])]
    private ?int $standbyModeLatency = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['terminal:read'])]
    private ?int $nextAdLatency = null;

    #[ORM\ManyToOne(inversedBy: 'terminal')]
    #[Groups(['terminal:read'])]
    private ?Updates $updates = null;

    #[ORM\ManyToOne(inversedBy: 'terminal')]
    private ?AdSetting $adSetting = null;

    public function __toString(): string
    {
        return $this->title ?: 'Нет терминалов';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getStandbyModeLatency(): ?int
    {
        return $this->standbyModeLatency;
    }

    public function setStandbyModeLatency(?int $standbyModeLatency): static
    {
        $this->standbyModeLatency = $standbyModeLatency;

        return $this;
    }

    public function getNextAdLatency(): ?int
    {
        return $this->nextAdLatency;
    }

    public function setNextAdLatency(?int $nextAdLatency): static
    {
        $this->nextAdLatency = $nextAdLatency;

        return $this;
    }

    public function getUpdates(): ?Updates
    {
        return $this->updates;
    }

    public function setUpdates(?Updates $updates): static
    {
        $this->updates = $updates;

        return $this;
    }

    public function getAdSetting(): ?AdSetting
    {
        return $this->adSetting;
    }

    public function setAdSetting(?AdSetting $adSetting): static
    {
        $this->adSetting = $adSetting;

        return $this;
    }
}
