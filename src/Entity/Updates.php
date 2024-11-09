<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\UpdatesRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UpdatesRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['updates:read']],
    paginationEnabled: false
)]
class Updates
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['updates:read', 'terminal:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['updates:read', 'terminal:read'])]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['updates:read', 'terminal:read'])]
    private ?string $version = null;

    #[Vich\UploadableField(mapping: 'update_targets', fileNameProperty: 'target')]
    #[Assert\Image(mimeTypes: ['application/zip', 'application/x-rar-compressed', 'application/gzip'])]
    private ?File $targetFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['updates:read', 'terminal:read'])]
    private ?string $target = null;

    /**
     * @var Collection<int, Terminal>
     */
    #[ORM\OneToMany(mappedBy: 'updates', targetEntity: Terminal::class)]
    private Collection $terminal;

    public function __toString(): string
    {
        return $this->description.' - '.$this->version ?? 'Не указано'; // Вернуть описание или 'Не указано', если его нет
    }

    public function __construct()
    {
        $this->terminal = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Terminal>
     */
    public function getTerminal(): Collection
    {
        return $this->terminal;
    }

    public function addTerminal(Terminal $terminal): static
    {
        if (!$this->terminal->contains($terminal)) {
            $this->terminal->add($terminal);
            $terminal->setUpdates($this);
        }

        return $this;
    }

    public function removeTerminal(Terminal $terminal): static
    {
        if ($this->terminal->removeElement($terminal)) {
            // set the owning side to null (unless already changed)
            if ($terminal->getUpdates() === $this) {
                $terminal->setUpdates(null);
            }
        }

        return $this;
    }
}
