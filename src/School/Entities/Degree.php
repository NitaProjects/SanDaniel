<?php

namespace App\School\Entities;

class Degree
{
    private int $id;              
    private string $name;         
    private int $durationYears;   
    public function __construct(string $name, int $durationYears)
    {
        $this->setName($name);
        $this->setDurationYears($durationYears);
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
            throw new \InvalidArgumentException("Degree name cannot be empty.");
        }
        if (strlen($name) > 150) {
            throw new \InvalidArgumentException("Degree name cannot exceed 150 characters.");
        }
        $this->name = $name;
        return $this;
    }

    public function getDurationYears(): int
    {
        return $this->durationYears;
    }

    public function setDurationYears(int $durationYears): self
    {
        if ($durationYears <= 0) {
            throw new \InvalidArgumentException("Duration years must be a positive integer.");
        }
        $this->durationYears = $durationYears;
        return $this;
    }
}
