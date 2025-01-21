<?php

declare(strict_types=1);

namespace App\School\Entities;

class User
{
    private ?int $id = null;
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
        $this->setPassword($password); // Hash automático
        $this->userType = $userType;  // Sin validación, se asume correcta
    }

    public function getId(): ?int
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
            throw new \InvalidArgumentException("El nombre no puede estar vacío.");
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
            throw new \InvalidArgumentException("El apellido no puede estar vacío.");
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
            throw new \InvalidArgumentException("El formato del correo electrónico no es válido.");
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
        $this->password = password_hash($password, PASSWORD_DEFAULT);
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
