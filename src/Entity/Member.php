<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\Api\Member\ControllerHarovchane;
use App\Controller\Api\Member\ControllerHeroes;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\MemberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: 'members/heroes', controller: ControllerHeroes::class),
        new GetCollection(uriTemplate: 'members/harovchane', controller: ControllerHarovchane::class),
        new GetCollection(),
        new Get()
    ],
    normalizationContext: ['groups' => ['member:read']],
    paginationEnabled: false
)]
#[ORM\Entity(repositoryClass: MemberRepository::class)]
class Member
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('member:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('member:read')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('member:read')]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('member:read')]
    private ?string $patronymic = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('member:read')]
    private ?string $biography = null;

    #[ORM\Column(nullable: true)]
    #[Groups('member:read')]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups('member:read')]
    private ?\DateTimeImmutable $endAt = null;

    /**
     * @var Collection<int, MemberAudio>
     */
    #[ORM\OneToMany(mappedBy: 'member', targetEntity: MemberAudio::class, cascade: ['all'])]
    #[Groups('member:read')]
    private Collection $audios;

    /**
     * @var Collection<int, MemberVideo>
     */
    #[ORM\OneToMany(mappedBy: 'member', targetEntity: MemberVideo::class, cascade: ['all'])]
    #[Groups('member:read')]
    private Collection $videos;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    /**
     * @var Collection<int, MemberImages>
     */
    #[ORM\OneToMany(mappedBy: 'member', targetEntity: MemberImages::class, cascade: ['all'])]
    #[Groups('member:read')]
    private Collection $images;

    /**
     * @var Collection<int, MemberPoetry>
     */
    #[ORM\OneToMany(mappedBy: 'member', targetEntity: MemberPoetry::class, cascade: ['all'])]
    #[Groups('member:read')]
    private Collection $poetry;

    public function __construct()
    {
        $this->audios = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->poetry = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): static
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return Collection<int, MemberAudio>
     */
    public function getAudios(): Collection
    {
        return $this->audios;
    }

    public function addAudio(MemberAudio $audio): static
    {
        if (!$this->audios->contains($audio)) {
            $this->audios->add($audio);
            $audio->setMember($this);
        }

        return $this;
    }

    public function removeAudio(MemberAudio $audio): static
    {
        if ($this->audios->removeElement($audio)) {
            // set the owning side to null (unless already changed)
            if ($audio->getMember() === $this) {
                $audio->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MemberVideo>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(MemberVideo $video): static
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setMember($this);
        }

        return $this;
    }

    public function removeVideo(MemberVideo $video): static
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getMember() === $this) {
                $video->setMember(null);
            }
        }

        return $this;
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

    /**
     * @return Collection<int, MemberImages>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(MemberImages $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setMember($this);
        }

        return $this;
    }

    public function removeImage(MemberImages $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getMember() === $this) {
                $image->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MemberPoetry>
     */
    public function getPoetry(): Collection
    {
        return $this->poetry;
    }

    public function addPoetry(MemberPoetry $poetry): static
    {
        if (!$this->poetry->contains($poetry)) {
            $this->poetry->add($poetry);
            $poetry->setMember($this);
        }

        return $this;
    }

    public function removePoetry(MemberPoetry $poetry): static
    {
        if ($this->poetry->removeElement($poetry)) {
            // set the owning side to null (unless already changed)
            if ($poetry->getMember() === $this) {
                $poetry->setMember(null);
            }
        }

        return $this;
    }
}
