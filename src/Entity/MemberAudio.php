<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\MemberAudioRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: MemberAudioRepository::class)]
class MemberAudio
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('member:read')]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'member_audio', fileNameProperty: 'audio')]
    #[Assert\Image(mimeTypes: ['audio/mp3', 'audio/wav', 'audio/mpeg'])]
    private ?File $audioFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('member:read')]
    private ?string $audio = null;

    #[ORM\ManyToOne(inversedBy: 'audios')]
    private ?Member $member = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('member:read')]
    private ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): static
    {
        $this->audio = $audio;

        return $this;
    }

    public function getAudioFile(): ?File
    {
        return $this->audioFile;
    }

    public function setAudioFile(?File $audioFile): self
    {
        $this->audioFile = $audioFile;
        if (null !== $audioFile) {
            $this->updatedAt = new DateTime();
        }

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        $this->member = $member;

        return $this;
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
}
