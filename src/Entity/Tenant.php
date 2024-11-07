<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;

use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\TenantRepository;
use DateTime;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;

use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TenantRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new GetCollection(),
        new GetCollection(uriTemplate: 'tenants/search'),
        new Get(),
        new Patch(),
    ],
    normalizationContext: ['groups' => ['tenant:read']],
    paginationEnabled: false
)]
class Tenant
{
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['tenant:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tenant:read', 'category:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['tenant:read', 'category:read'])]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['tenant:read', 'category:read'])]
    private ?string $description = null;

    #[Vich\UploadableField(mapping: 'tenants_logos', fileNameProperty: 'image')]
    #[Assert\Image(mimeTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])]
    #[Groups(['tenant:read', 'category:read'])]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Groups(['tenant:read', 'category:read'])]
    private ?string $image = null;

    /**
     * @var Collection<int, MemberImages>
     */
    #[ORM\OneToMany(mappedBy: 'tenant', targetEntity: MemberImages::class, cascade: ['persist', 'remove'])]
    #[Groups(['tenant:read', 'category:read'])]
    private Collection $photos;

    #[ORM\ManyToOne(inversedBy: 'tenant')]
    #[Groups(['tenant:read', 'category:read'])]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'tenant')]
    #[Groups(['tenant:read', 'category:read'])]
    private ?Floor $floor = null;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->category ? $this->category->__toString() : 'Нет обновления'; // Теперь использует __toString() из Updates
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getFloor(): ?Floor
    {
        return $this->floor;
    }

    public function setFloor(?Floor $floor): static
    {
        $this->floor = $floor;

        return $this;
    }
}
