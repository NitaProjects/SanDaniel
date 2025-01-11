<?php

namespace App\School\Entities;

use App\School\Entities\Student;
use App\School\Entities\Course;

class Enrollment
{
    private int $id;
    private Student $student;
    private Course $course; 
    private \DateTime $enrollmentDate;

    public function __construct(Student $student, Course $course, \DateTime $enrollmentDate)
    {
        $this->student = $student;
        $this->course = $course;
        $this->enrollmentDate = $enrollmentDate;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function getEnrollmentDate(): \DateTime
    {
        return $this->enrollmentDate;
    }
}
