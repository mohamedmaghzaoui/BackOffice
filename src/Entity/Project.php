<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    //id
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    //name

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "name cannot be empty")]
    private ?string $name = null;
    //image

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "image cannot be empty")]
    private ?string $image = null;
    //description


    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "description cannot be empty")]
    #[Assert\Length(
        min: 20,
        max: 500,
        minMessage: "description too short",
        maxMessage: "description too long"

    )]
    private ?string $description = null;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

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
}