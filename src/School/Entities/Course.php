<?php

namespace App\School\Entities;

use App\School\Entities\Subject;

class Course
{
    protected int $id;
    protected string $name;
    protected array $subjects = [];
    protected ?Degree $degree = null;

    public function __construct(string $name)
    {
        $this->name = $name;
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

    public function addSubject(Subject $subject): self
    {
        $this->subjects[] = $subject;
        return $this;
    }

    public function getSubjects(): array
    {
        return $this->subjects;
    }

    public function setDegree(Degree $degree): self
    {
        $this->degree = $degree;
        return $this;
    }

    public function getDegree(): ?Degree
    {
        return $this->degree;
    }
}
