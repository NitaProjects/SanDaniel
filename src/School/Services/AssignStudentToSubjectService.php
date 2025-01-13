<?php

namespace App\School\Services;

use App\School\Entities\Student;
use App\School\Entities\Subject;
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Repositories\Implementations\EnrollmentRepository;

class AssignStudentToSubjectService
{
    private StudentRepository $studentRepository;
    private EnrollmentRepository $enrollmentRepository;

    public function __construct(StudentRepository $studentRepo, EnrollmentRepository $enrollmentRepo)
    {
        $this->studentRepository = $studentRepo;
        $this->enrollmentRepository = $enrollmentRepo;
    }

    public function assign(Student $student, Subject $subject): void
    {
        // Verificar si el estudiante existe en el repositorio
        $student = $this->studentRepository->findById($student->getId());
        if (!$student) {
            throw new \Exception("Student not found");
        }

        // Crear una nueva inscripción (enrollment)
        $enrollment = new \App\School\Entities\Enrollment($student, $subject, new \DateTime());

        // Guardar la inscripción en el repositorio de enrollments
        $this->enrollmentRepository->save($enrollment);
    }
}
