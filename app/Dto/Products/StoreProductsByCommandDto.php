<?php

declare(strict_types=1);

namespace App\Dto\Products;


class StoreProductsByCommandDto 
{
    private function __construct(
        private readonly string $name,
        private readonly float $price,
        private readonly string $description,
        private readonly string $category,
        private readonly ?string $imageUrl
    )
    {
        
    }

    public static function create(string $name, float $price, string $description, string $category, ?string $imageUrl = null): self
    {
        return new self(
            $name,
            $price,
            $description,
            $category,
            $imageUrl
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getAll(): array
    {
        return get_object_vars($this);
    }
}