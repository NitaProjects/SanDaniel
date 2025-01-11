<?php

namespace App\School\Services;

use App\School\Entities\Student;
use App\School\Entities\Course;
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Repositories\Implementations\EnrollmentRepository;

class AssignStudentToCourseService
{
    private StudentRepository $studentRepository;
    private EnrollmentRepository $enrollmentRepository;

    public function __construct(StudentRepository $studentRepo, EnrollmentRepository $enrollmentRepo)
    {
        $this->studentRepository = $studentRepo;
        $this->enrollmentRepository = $enrollmentRepo;
    }

    public function assign(Student $student, Course $course): void
    {
        $student = $this->studentRepository->findById($student->getId());
        if (!$student) {
            throw new \Exception("Student not found");
        }

        $enrollment = new \App\School\Entities\Enrollment($student, $course, new \DateTime());
        $this->enrollmentRepository->save($enrollment);
    }
}
