<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\FloorRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FloorRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
    ],
    normalizationContext: ['groups' => ['floor:read']],
    paginationEnabled: false,
)]
class Floor
{
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('floor:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['floor:read', 'tenant;read', 'category:read'])]
    private ?string $floor = null;

    #[Vich\UploadableField(mapping: 'floor_images', fileNameProperty: 'image')]
    #[Assert\Image(mimeTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups('floor:read')]
    private ?string $image = null;

    /**
     * @var Collection<int, Tenant>
     */
    #[ORM\OneToMany(mappedBy: 'floor', targetEntity: Tenant::class)]
    private Collection $tenant;

    public function __construct()
    {
        $this->tenant = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->floor ?? 'Не указано'; // Вернуть описание или 'Не указано', если его нет
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(?string $floor): static
    {
        $this->floor = $floor;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile)
            $this->updatedAt = new DateTime();

        return $this;
    }

    /**
     * @return Collection<int, Tenant>
     */
    public function getTenant(): Collection
    {
        return $this->tenant;
    }

    public function addTenant(Tenant $tenant): static
    {
        if (!$this->tenant->contains($tenant)) {
            $this->tenant->add($tenant);
            $tenant->setFloor($this);
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): static
    {
        if ($this->tenant->removeElement($tenant)) {
            // set the owning side to null (unless already changed)
            if ($tenant->getFloor() === $this) {
                $tenant->setFloor(null);
            }
        }

        return $this;
    }
}
