<?php

namespace App\School\Entities;

class Teacher extends User
{
    private int $id; // ID único en la tabla de teachers
    private int $userId; // Relación con el usuario en la tabla de users
    private array $departments = []; // Departamentos asociados al profesor

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        int $userId,
        array $departments = []
    ) {
        parent::__construct($firstName, $lastName, $email, $password, 'teacher');
        $this->setUserId($userId);
        $this->setDepartments($departments);
    }

    // Obtener el ID único de la tabla teachers
    public function getId(): int
    {
        return $this->id;
    }

    // Establecer el ID único de la tabla teachers
    public function setId(int $id): self
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException("ID must be a positive integer.");
        }
        $this->id = $id;
        return $this;
    }

    // Obtener el user_id relacionado
    public function getUserId(): int
    {
        return $this->userId;
    }

    // Establecer el user_id relacionado
    public function setUserId(int $userId): self
    {
        if ($userId <= 0) {
            throw new \InvalidArgumentException("User ID must be a positive integer.");
        }
        $this->userId = $userId;
        return $this;
    }

    // Obtener los departamentos asociados
    public function getDepartments(): array
    {
        return $this->departments;
    }

    // Establecer los departamentos asociados
    public function setDepartments(array $departments): self
    {
        $this->departments = $departments;
        return $this;
    }

    // Asociar un departamento
    public function addDepartment(Department $department): self
    {
        if (!in_array($department, $this->departments, true)) {
            $this->departments[] = $department;
        }
        return $this;
    }

    // Eliminar un departamento
    public function removeDepartment(Department $department): self
    {
        $this->departments = array_filter(
            $this->departments,
            fn($d) => $d !== $department
        );
        return $this;
    }
}
