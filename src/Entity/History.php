<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\Api\History\ControllerHarovsk;
use App\Controller\Api\History\ControllerHistory;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\HistoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\HasLifecycleCallbacks]
//#[ApiResource(
//    operations: [
//        new GetCollection(uriTemplate: 'history/heroes', controller: ControllerHistory::class),
//        new GetCollection(uriTemplate: 'history/harovsk', controller: ControllerHarovsk::class),
//        new GetCollection(),
//        new Get()
//    ],
//    normalizationContext: ['groups' => ['history:read']],
//    paginationEnabled: false
//)]
#[ORM\Entity(repositoryClass: HistoryRepository::class)]
class History
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
//    #[Groups(['history:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
//    #[Groups(['history:read'])]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT)]
//    #[Groups(['history:read'])]
    private ?string $description = null;

    /**
     * @var Collection<int, HistoryImages>
     */
    #[ORM\OneToMany(mappedBy: 'history', targetEntity: HistoryImages::class, cascade: ['all'])]
//    #[Groups(['history:read'])]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, HistoryImages>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(HistoryImages $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setHistory($this);
        }

        return $this;
    }

    public function removeImage(HistoryImages $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getHistory() === $this) {
                $image->setHistory(null);
            }
        }

        return $this;
    }
}
