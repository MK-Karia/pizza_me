<?php
declare(strict_types=1);

namespace App\Entity;
class User
{
    public function __construct(
        private ?int $id, 
        private string $firstName, 
        private string $lastName,
        private string $email,
        private ?string $phone,
        private ?string $avatarPath
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName($first_name): void 
    {
        $this->firstName = $first_name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName($last_name): void
    {
        $this->lastName = $last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }

    public function getAvatarPath(): ?string
    {
        return $this->avatarPath;
    }

    public function setAvatarPath(?string $avatarPath): void
    {
        $this->avatarPath = $avatarPath;
    }
}