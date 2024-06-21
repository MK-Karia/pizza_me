<?php
declare(strict_types=1);

namespace App\Entity;
class Order
{
    public function __construct(
        private ?int $id, 
        private int $userId, 
        private int $pizzaId,
        private string $address,
        private int $price,
        private ?\DateTimeImmutable $orderDate
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId($userId): void 
    {
        $this->userId = $userId;
    }

    public function getPizzaId(): int
    {
        return $this->pizzaId;
    }

    public function setPizzaId($pizzaId): void 
    {
        $this->pizzaId = $pizzaId;
    }


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getOrderDate(): ?\DateTimeImmutable
    {
        return $this->orderDate;
    }

    public function setOrderDate(?\DateTimeImmutable $orderDate): void
    {
        $this->orderDate = $orderDate;
    }
}