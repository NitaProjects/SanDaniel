<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\AssignStudentToSubjectService; // Servicio corregido
use App\School\Entities\Student;
use App\School\Entities\Subject;
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Repositories\Implementations\EnrollmentRepository;

class AssignStudentToSubjectServiceTest extends TestCase
{
    public function testAssignStudentToSubject(): void
    {
        // Mock de StudentRepository
        $studentRepo = $this->createMock(StudentRepository::class);
        $studentRepo->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn(new Student("John", "Doe", "john@example.com", "password", "student", "12345678A", 2022));

        // Mock de EnrollmentRepository
        $enrollmentRepo = $this->createMock(EnrollmentRepository::class);
        $enrollmentRepo->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(\App\School\Entities\Enrollment::class));

        // Servicio que estamos probando
        $service = new AssignStudentToSubjectService($studentRepo, $enrollmentRepo); // Cambiar el nombre del servicio

        // Entidades para la prueba
        $student = new Student("John", "Doe", "john@example.com", "password", "student", "12345678A", 2022);
        $student->setId(1);

        $subject = new Subject("Mathematics"); // Cambiado a Subject
        $subject->setId(1);

        // Ejecutar el caso de uso
        $service->assign($student, $subject);

        // Si no hay excepciones, la prueba pasa.
        $this->assertTrue(true);
    }
}
