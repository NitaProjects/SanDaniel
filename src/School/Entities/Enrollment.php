<?php

namespace App\School\Entities;

use App\School\Entities\Student;
use App\School\Entities\Subject;

class Enrollment
{
    private int $id; // ID de la inscripción
    private Student $student; // Relación con el estudiante
    private Subject $subject; // Relación con la asignatura
    private \DateTime $enrollmentDate; // Fecha de inscripción

    public function __construct(Student $student, Subject $subject, \DateTime $enrollmentDate)
    {
        $this->student = $student;
        $this->subject = $subject;
        $this->enrollmentDate = $enrollmentDate;
    }

    // Métodos para manejar el ID
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    // Métodos para manejar el estudiante
    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): self
    {
        $this->student = $student;
        return $this;
    }

    // Métodos para manejar la asignatura
    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function setSubject(Subject $subject): self
    {
        $this->subject = $subject;
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
