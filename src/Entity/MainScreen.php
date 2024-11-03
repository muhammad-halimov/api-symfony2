<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Repository\MainScreenRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection()
    ],
    paginationEnabled: false
)]
#[ORM\Entity(repositoryClass: MainScreenRepository::class)]
class MainScreen
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titleSvo = null;

    #[ORM\Column(length: 255)]
    private ?string $titleHeroes = null;

    #[ORM\Column(length: 255)]
    private ?string $titleMembers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleSvo(): ?string
    {
        return $this->titleSvo;
    }

    public function setTitleSvo(string $titleSvo): static
    {
        $this->titleSvo = $titleSvo;

        return $this;
    }

    public function getTitleHeroes(): ?string
    {
        return $this->titleHeroes;
    }

    public function setTitleHeroes(string $titleHeroes): static
    {
        $this->titleHeroes = $titleHeroes;

        return $this;
    }

    public function getTitleMembers(): ?string
    {
        return $this->titleMembers;
    }

    public function setTitleMembers(string $titleMembers): static
    {
        $this->titleMembers = $titleMembers;

        return $this;
    }
}
