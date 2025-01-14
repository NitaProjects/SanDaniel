<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\IStudentRepository;
use App\School\Entities\Student;

class StudentService
{
    private IStudentRepository $studentRepository;

    public function __construct(IStudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function createStudent(
        int $userId,
        string $dni,
        int $enrollmentYear
    ): Student {
        // Crear un nuevo estudiante
        $student = new Student('', '', '', '', 'student', $dni, $enrollmentYear, $userId);
        $this->studentRepository->save($student);

        return $student;
    }

    public function getStudentById(int $id): ?Student
    {
        return $this->studentRepository->findById($id);
    }

    public function getStudentByDni(string $dni): ?Student
    {
        return $this->studentRepository->findByDni($dni);
    }

    public function getStudentByUserId(int $userId): ?Student
    {
        return $this->studentRepository->findByUserId($userId);
    }

    public function getStudentsByEnrollmentYear(int $year): array
    {
        return $this->studentRepository->findByEnrollmentYear($year);
    }

    public function updateStudent(
        int $id,
        string $dni,
        int $enrollmentYear
    ): void {
        $student = $this->getStudentById($id);

        if (!$student) {
            throw new \Exception("Student with ID $id not found.");
        }

        $student->setDni($dni)
                ->setEnrollmentYear($enrollmentYear);

        $this->studentRepository->save($student);
    }

    public function deleteStudent(int $id): void
    {
        $this->studentRepository->delete($id);
    }

    public function getAllStudents(): array
    {
        return $this->studentRepository->getAll();
    }
}
