<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\TenantRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TenantRepository::class)]
#[Vich\Uploadable]
#[ApiResource]
class Tenant
{
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[Vich\UploadableField(mapping: 'tenants_logos', fileNameProperty: 'image')]
    #[Assert\Image(mimeTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $image = null;

    /**
     * @var Collection<int, MemberImages>
     */
    #[ORM\OneToMany(mappedBy: 'tenant', targetEntity: MemberImages::class, cascade: ['persist', 'remove'])]
    private Collection $photos;

    #[ORM\Column(type: 'string', nullable: true)]
    #[ORM\OneToOne(mappedBy: 'floor', targetEntity: Floor::class, cascade: ['persist', 'remove'])]
    private Floor|int|null $floor = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[ORM\OneToOne(mappedBy: 'category', targetEntity: Category::class, cascade: ['persist', 'remove'])]
    private Category|int|null $category = null;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
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

    public function getCategory(): Category|int|null
    {
        return $this->category;
    }

    public function setCategory(Category|int|null $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getFloor(): Floor|int|null
    {
        return $this->floor;
    }

    public function setFloor(Floor|int|null $floor): static
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

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
        if (null !== $imageFile) {
            $this->updatedAt = new DateTime();
        }

        return $this;
    }


    /**
     * @return Collection<int, MemberImages>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(MemberImages $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setTenant($this);
        }

        return $this;
    }

    public function removePhoto(MemberImages $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getTenant() === $this) {
                $photo->setTenant(null);
            }
        }

        return $this;
    }
}
