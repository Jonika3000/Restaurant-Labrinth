<?php

namespace App\Entity;

use App\Repository\DishTranslateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishTranslateRepository::class)]
class DishTranslate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?SiteLocale $locale = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dish $dish = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocale(): ?SiteLocale
    {
        return $this->locale;
    }

    public function setLocale(?SiteLocale $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getDish(): ?Dish
    {
        return $this->dish;
    }

    public function setDish(?Dish $dish): static
    {
        $this->dish = $dish;

        return $this;
    }
}
