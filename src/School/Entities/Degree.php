<?php

namespace App\School\Entities;

use App\School\Entities\Course;

class Degree
{
    private int $id;
    private string $name;
    private array $courses = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function addCourse(Course $course): self
    {
        $this->courses[] = $course;
        return $this;
    }

    public function getCourses(): array
    {
        return $this->courses;
    }
}
