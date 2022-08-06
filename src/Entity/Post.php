<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Post:collection']],
    denormalizationContext: ['groups' => ['write:Post']],
    itemOperations: [
        'put' => [
            'denormalization_context' => ['groups' => ['write:Post']]
        ],
        'delete',
        'get' => [
            'normalization_context' => ['groups' => ['read:Post:collection', 'read:Post:item', 'read:Post:Category']]
        ]]
)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Post:collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[
        Groups(['read:Post:collection', 'write:Post']),
        Length(min: 5)
    ]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:Post:collection', 'write:Post'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['read:Post:item', 'write:Post'])]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:Post:item'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read:Post:item'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'posts', cascade: ['persist'])]
    #[
        Groups(['read:Post:item', 'write:Post']),
        Valid()
    ]
    private ?Category $category = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
