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

    public function createEnrollment(int $studentId, int $subjectId, \DateTime $enrollmentDate): Enrollment
    {
        $enrollment = new Enrollment($studentId, $subjectId, $enrollmentDate);
        $this->enrollmentRepository->save($enrollment);

        return $enrollment;
    }

    public function updateEnrollment(int $id, int $studentId, int $subjectId, \DateTime $enrollmentDate): void
    {
        $enrollment = $this->getEnrollmentById($id);

        if (!$enrollment) {
            throw new \Exception("Enrollment with ID $id not found.");
        }

        $enrollment->setStudentId($studentId)
                   ->setSubjectId($subjectId)
                   ->setEnrollmentDate($enrollmentDate);

        $this->enrollmentRepository->save($enrollment);
    }

    public function getEnrollmentById(int $id): ?Enrollment
    {
        return $this->enrollmentRepository->findById($id);
    }

    public function getEnrollmentsByStudentId(int $studentId): array
    {
        return $this->enrollmentRepository->findByStudentId($studentId);
    }

    public function getEnrollmentsBySubjectId(int $subjectId): array
    {
        return $this->enrollmentRepository->findBySubjectId($subjectId);
    }

    public function getEnrollmentsByDate(\DateTime $enrollmentDate): array
    {
        return $this->enrollmentRepository->findByEnrollmentDate($enrollmentDate);
    }

    public function deleteEnrollment(int $id): void
    {
        $this->enrollmentRepository->delete($id);
    }

    public function getAllEnrollments(): array
    {
        return $this->enrollmentRepository->getAll();
    }
}
