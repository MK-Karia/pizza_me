<?php
declare(strict_types=1);

namespace App\Entity;
class Pizza
{
    public function __construct(
        private ?int $id, 
        private string $name, 
        private ?string $ingredients,
        private ?string $discription,
        private int $price,
        private ?string $imagePath
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void 
    {
        $this->name = $name;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients($ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    public function getDiscription(): ?string
    {
        return $this->discription;
    }

    public function setDiscription($discription): void
    {
        $this->discription = $discription;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }
}