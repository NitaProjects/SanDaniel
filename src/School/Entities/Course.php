<?php

namespace App\School\Entities;

class Course
{
    protected int $id;
    protected string $name;
    protected int $degreeId; 

    public function __construct(string $name, int $degreeId)
    {
        $this->setName($name);
        $this->setDegreeId($degreeId);
    }

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Course name cannot be empty.");
        }
        if (strlen($name) > 150) {
            throw new \InvalidArgumentException("Course name cannot exceed 150 characters.");
        }
        $this->name = $name;
        return $this;
    }

    public function getDegreeId(): int
    {
        return $this->degreeId;
    }

    public function setDegreeId(int $degreeId): self
    {
        if ($degreeId <= 0) {
            throw new \InvalidArgumentException("Degree ID must be a positive integer.");
        }
        $this->degreeId = $degreeId;
        return $this;
    }
}
