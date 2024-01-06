<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Range;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    //id
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    //name
    #[Assert\NotBlank(message: "name cannot be empty")]
    private ?string $name = null;


    //mastery

    #[ORM\Column]
    #[Assert\NotBlank(message: "mastery cannot be empty", allowNull: false)]
    #[Range(
        min: 0,
        max: 100,
        notInRangeMessage: "mastery must be a number between 0 and 100"
    )]



    private ?int $mastery = null;

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

    public function getMastery(): ?int
    {
        return $this->mastery;
    }

    public function setMastery(int $mastery): static
    {
        $this->mastery = $mastery;

        return $this;
    }
}