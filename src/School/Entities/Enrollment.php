<?php

namespace App\School\Entities;

use App\School\Entities\Student;
use App\School\Entities\Subject;

class Enrollment
{
    private int $id;
    private Student $student;
    private ?Subject $subject = null;
    private \DateTime $enrollmentDate;

    public function __construct(Student $student, Subject $subject, \DateTime $enrollmentDate)
    {
        $this->student = $student;
        $this->subject = $subject;
        $this->enrollmentDate = $enrollmentDate;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function getEnrollmentDate(): \DateTime
    {
        return $this->enrollmentDate;
    }
}
