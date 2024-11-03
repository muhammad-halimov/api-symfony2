<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\StandbyModeRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StandbyModeRepository::class)]
#[ApiResource]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class StandbyMode
{
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'standby_targets', fileNameProperty: 'target')]
    #[Assert\Image(mimeTypes: ['video/mp4', 'video/avi', 'video/wmv',])]
    private ?File $targetFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $target = null;

    #[ORM\Column(nullable: true)]
    private ?bool $turnOn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarget(): ?string
    {
        return $this->target;
    }

    public function setTarget(?string $target): static
    {
        $this->target = $target;

        return $this;
    }

    public function isTurnOn(): ?bool
    {
        return $this->turnOn;
    }

    public function setTurnOn(?bool $turnOn): static
    {
        $this->turnOn = $turnOn;

        return $this;
    }

    public function getTargetFile(): ?File
    {
        return $this->targetFile;
    }

    public function setTargetFile(?File $targetFile): self
    {
        $this->targetFile = $targetFile;

        if (null !== $targetFile)
            $this->updatedAt = new DateTime();

        return $this;
    }
}
