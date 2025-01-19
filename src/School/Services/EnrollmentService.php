<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\IEnrollmentRepository;
use App\School\Entities\Enrollment;

class EnrollmentService
{
    private IEnrollmentRepository $enrollmentRepository;

    public function __construct(IEnrollmentRepository $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    /**
     * Crear una nueva matrícula.
     */
    public function addEnrollment(int $studentId, int $subjectId, \DateTime $enrollmentDate): Enrollment
    {
        $enrollment = new Enrollment($studentId, $subjectId, $enrollmentDate);
        $this->enrollmentRepository->add($enrollment);

        return $enrollment;
    }

    /**
     * Actualizar una matrícula existente.
     */
    public function updateEnrollment(int $id, int $studentId, int $subjectId, \DateTime $enrollmentDate): void
    {
        $enrollment = $this->getEnrollmentById($id);

        if (!$enrollment) {
            throw new \Exception("Enrollment with ID $id not found.");
        }

        $enrollment->setStudentId($studentId)
                   ->setSubjectId($subjectId)
                   ->setEnrollmentDate($enrollmentDate);

        $this->enrollmentRepository->update($enrollment);
    }

    /**
     * Obtener una matrícula por su ID.
     */
    public function getEnrollmentById(int $id): ?Enrollment
    {
        return $this->enrollmentRepository->findById($id);
    }

    /**
     * Eliminar una matrícula.
     */
    public function deleteEnrollment(int $id): void
    {
        $this->enrollmentRepository->delete($id);
    }

    /**
     * Obtener todas las matrículas.
     */
    public function getAllEnrollments(): array
    {
        return $this->enrollmentRepository->getAll();
    }
}
