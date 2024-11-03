<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TerminalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerminalRepository::class)]
#[ApiResource]
class Terminal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?int $standbyModeLatency = null;

    #[ORM\Column(nullable: true)]
    private ?int $nextAdLatency = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Updates $updates = null;

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
}
