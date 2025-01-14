<?php

namespace App\School\Entities;

class Department
{
    private int $id;          
    private string $name;     

    public function __construct(string $name)
    {
        $this->setName($name); 
    }

    // Getters y Setters para ID
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException("ID must be a positive integer.");
        }
        $this->id = $id;
        return $this;
    }

    // Getters y Setters para Name
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Department name cannot be empty.");
        }
        if (strlen($name) > 100) {
            throw new \InvalidArgumentException("Department name cannot exceed 100 characters.");
        }
        $this->name = $name;
        return $this;
    }
}
