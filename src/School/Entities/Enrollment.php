<?php

namespace App\School\Entities;

class Enrollment
{
    private int $id; 
    private int $studentId; 
    private int $subjectId; 
    private \DateTime $enrollmentDate; 

    public function __construct(int $studentId, int $subjectId, \DateTime $enrollmentDate)
    {
        $this->setStudentId($studentId);
        $this->setSubjectId($subjectId);
        $this->setEnrollmentDate($enrollmentDate);
    }

    // Métodos para manejar el ID
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

    // Métodos para manejar el studentId
    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function setStudentId(int $studentId): self
    {
        if ($studentId <= 0) {
            throw new \InvalidArgumentException("Student ID must be a positive integer.");
        }
        $this->studentId = $studentId;
        return $this;
    }

    // Métodos para manejar el subjectId
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

    // Métodos para manejar la fecha de inscripción
    public function getEnrollmentDate(): \DateTime
    {
        return $this->enrollmentDate;
    }

    public function setEnrollmentDate(\DateTime $enrollmentDate): self
    {
        $this->enrollmentDate = $enrollmentDate;
        return $this;
    }
}
