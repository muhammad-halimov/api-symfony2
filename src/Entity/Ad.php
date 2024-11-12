<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\Api\Ad\AdSettingsController;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\AdRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(),
        new GetCollection(uriTemplate: '/adDay', controller: AdSettingsController::class),
    ],
    normalizationContext: ['groups' => 'ads:read'],
    paginationEnabled: false
)]
#[Vich\Uploadable]
class Ad
{
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'ad_images', fileNameProperty: 'image')]
    #[Assert\File(mimeTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])]
    #[Groups(['ads:read'])]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['ads:read'])]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['ads:read'])]
    private ?bool $turnOn = null;

    /**
     * @var Collection<int, AdSetting>
     */
    #[ORM\OneToMany(mappedBy: 'ad', targetEntity: AdSetting::class, cascade: ['persist', 'remove'])]
    #[Groups(['ads:read'])]
    private Collection $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function optionsToString(): ?string
    {
        // Инициализируем массив для хранения строковых представлений каждого свойства
        $result = [];

        // Проходим по всем опциям
        foreach ($this->options as $option) {
            $id = $option->getId();
            $startDate = $option->getBeginning()->format('d-m-Y, H:i');
            $endDate = $option->getEnding()->format('d-m-Y, H:i');
            $displayOrder = $option->getShowOrder();
            $terminals = $option->getTerminal() ? 'Да' : 'Нет';

            // Формируем строку для текущей опции
            $result[] = "
                $id) Дата начала - $startDate
                Дата конца - $endDate
                Порядок отображения - $displayOrder
                Терминалы - $terminals
            ";
        }

        // Объединяем все части в одну строку
        return implode("\n", $result);
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function isTurnOn(): ?bool
    {
        return $this->turnOn;
    }

    public function setTurnOn(?bool $turnOn): static
    {
        $this->turnOn = $turnOn;

        return $this;
    }

    /**
     * @return Collection<int, AdSetting>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(AdSetting $option): static
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
            $option->setAd($this);
        }

        return $this;
    }

    public function removeOption(AdSetting $option): static
    {
        if ($this->options->removeElement($option)) {
            // set the owning side to null (unless already changed)
            if ($option->getAd() === $this) {
                $option->setAd(null);
            }
        }

        return $this;
    }
}
