<?php

namespace App\School\Entities;

use DateTime;

class Exam
{
    private int $id;
    private int $subjectId; 
    private DateTime $examDate;
    private string $description; 

    public function __construct(int $subjectId, DateTime $examDate, string $description)
    {
        $this->setSubjectId($subjectId);
        $this->setExamDate($examDate);
        $this->setDescription($description);
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

    public function getSubjectId(): int
    {
        return $this->subjectId;
    }

    public function setSubjectId(int $subjectId): self
    {
        if ($subjectId <= 0) {
            throw new \InvalidArgumentException("Subject ID must be a positive integer.");
        }
        $this->subjectId = $subjectId;
        return $this;
    }

    public function getExamDate(): DateTime
    {
        return $this->examDate;
    }

    public function setExamDate(DateTime $examDate): self
    {
        $this->examDate = $examDate;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        if (empty($description)) {
            throw new \InvalidArgumentException("Description cannot be empty.");
        }
        if (strlen($description) > 255) {
            throw new \InvalidArgumentException("Description cannot exceed 255 characters.");
        }
        $this->description = $description;
        return $this;
    }
}
