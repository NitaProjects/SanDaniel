<?php

namespace App\School\Entities;

class Subject
{
    protected int $id;
    protected string $name;
    protected int $courseId;

    public function __construct(string $name, int $courseId)
    {
        $this->setName($name);
        $this->setCourseId($courseId);
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
            throw new \InvalidArgumentException("Subject name cannot be empty.");
        }
        if (strlen($name) > 150) {
            throw new \InvalidArgumentException("Subject name cannot exceed 150 characters.");
        }
        $this->name = $name;
        return $this;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function setCourseId(int $courseId): self
    {
        if ($courseId <= 0) {
            throw new \InvalidArgumentException("Course ID must be a positive integer.");
        }
        $this->courseId = $courseId;
        return $this;
    }
}
