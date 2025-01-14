<?php

namespace App\School\Entities;

class Teacher extends User
{
    private int $id;      
    private int $userId;  

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password
    ) {
        parent::__construct($firstName, $lastName, $email, $password, 'teacher');
    }

    // Obtener el ID del profesor
    public function getId(): int
    {
        return $this->id;
    }

    // Establecer el ID del profesor
    public function setId(int $id): self
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException("ID must be a positive integer.");
        }
        $this->id = $id;
        return $this;
    }

    // Obtener el userId relacionado
    public function getUserId(): int
    {
        return $this->userId;
    }

    // Establecer el userId relacionado
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
}
