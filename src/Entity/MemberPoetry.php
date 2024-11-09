<?php

namespace App\Entity;

use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\MemberPoetryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: MemberPoetryRepository::class)]
class MemberPoetry
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
//    #[Groups('member:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
//    #[Groups('member:read')]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
//    #[Groups('member:read')]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
//    #[Groups('member:read')]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'poetry')]
    private ?Member $member = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

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
}
