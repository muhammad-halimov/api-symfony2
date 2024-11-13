<?php

namespace App\Entity;

use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\AdSettingRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdSettingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class AdSetting
{
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ads:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['ads:read'])]
    private ?DateTimeInterface $beginning = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['ads:read'])]
    private ?DateTimeInterface $ending = null;

    /**
     * @var Collection<int, Terminal>
     */
    #[ORM\OneToMany(mappedBy: 'adSetting', targetEntity: Terminal::class, cascade: ['persist', 'remove'])]
    private Collection $terminal;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    #[Groups(['ads:read'])]
    private ?int $showOrder = null;

    #[ORM\ManyToOne(inversedBy: 'options')]
    private ?Ad $ad = null;

    public function __construct()
    {
        $this->terminal = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginning(): ?DateTimeInterface
    {
        return $this->beginning;
    }

    public function setBeginning(?DateTimeInterface $beginning): static
    {
        $this->beginning = $beginning;

        return $this;
    }

    public function getEnding(): ?DateTimeInterface
    {
        return $this->ending;
    }

    public function setEnding(?DateTimeInterface $ending): static
    {
        $this->ending = $ending;

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
            $terminal->setAdSetting($this);
        }

        return $this;
    }

    public function removeTerminal(Terminal $terminal): static
    {
        if ($this->terminal->removeElement($terminal)) {
            // set the owning side to null (unless already changed)
            if ($terminal->getAdSetting() === $this) {
                $terminal->setAdSetting(null);
            }
        }

        return $this;
    }

    public function getShowOrder(): ?string
    {
        return $this->showOrder;
    }

    public function setShowOrder(?string $showOrder): static
    {
        $this->showOrder = $showOrder;

        return $this;
    }

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): static
    {
        $this->ad = $ad;

        return $this;
    }
}
