<?php

namespace App\School\Entities;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $userType;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $userType
    ) {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setUserType($userType);
    }

    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        if (empty($firstName)) {
            throw new \InvalidArgumentException("First name cannot be empty");
        }
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        if (empty($lastName)) {
            throw new \InvalidArgumentException("Last name cannot be empty");
        }
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email format");
        }
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        if (strlen($password) < 6) {
            throw new \InvalidArgumentException("Password must be at least 6 characters long");
        }
        $this->password = $password;
        return $this;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function setUserType(string $userType): self
    {
        $this->userType = $userType;
        return $this;
    }
}
