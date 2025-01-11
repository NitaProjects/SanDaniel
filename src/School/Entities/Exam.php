<?php

namespace App\School\Entities;

use App\School\Entities\Subject;

class Exam
{
    private int $id;
    private Subject $subject;
    private \DateTime $examDate;
    private float $maxGrade;

    public function __construct(Subject $subject, \DateTime $examDate, float $maxGrade)
    {
        $this->subject = $subject;
        $this->examDate = $examDate;
        $this->maxGrade = $maxGrade;
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

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function setSubject(Subject $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getExamDate(): \DateTime
    {
        return $this->examDate;
    }

    public function setExamDate(\DateTime $examDate): self
    {
        $this->examDate = $examDate;
        return $this;
    }

    public function getMaxGrade(): float
    {
        return $this->maxGrade;
    }

    public function setMaxGrade(float $maxGrade): self
    {
        $this->maxGrade = $maxGrade;
        return $this;
    }
}
