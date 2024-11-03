<?php

namespace App\Entity;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\UpdatesRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UpdatesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Updates
{
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $version = null;

    #[Vich\UploadableField(mapping: 'update_targets', fileNameProperty: 'target')]
    #[Assert\Image(mimeTypes: ['application/zip', 'application/x-rar-compressed', 'application/gzip'])]
    private ?File $targetFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $target = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): static
    {
        $this->version = $version;

        return $this;
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
