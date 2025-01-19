<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Enrollment;
use App\School\Repositories\Interfaces\IEnrollmentRepository;
use PDO;

class EnrollmentRepository implements IEnrollmentRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function add(Enrollment $enrollment): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO enrollments (student_id, subject_id, enrollment_date)
            VALUES (:student_id, :subject_id, :enrollment_date)
        ");

        $stmt->bindValue(':student_id', $enrollment->getStudentId());
        $stmt->bindValue(':subject_id', $enrollment->getSubjectId());
        $stmt->bindValue(':enrollment_date', $enrollment->getEnrollmentDate()->format('Y-m-d'));
        $stmt->execute();
    }

    public function update(Enrollment $enrollment): void
    {
        $stmt = $this->db->prepare("
            UPDATE enrollments SET 
                student_id = :student_id,
                subject_id = :subject_id,
                enrollment_date = :enrollment_date
            WHERE id = :id
        ");

        $stmt->bindValue(':id', $enrollment->getId());
        $stmt->bindValue(':student_id', $enrollment->getStudentId());
        $stmt->bindValue(':subject_id', $enrollment->getSubjectId());
        $stmt->bindValue(':enrollment_date', $enrollment->getEnrollmentDate()->format('Y-m-d'));
        $stmt->execute();
    }

    public function findById(int $id): ?Enrollment
    {
        $stmt = $this->db->prepare("SELECT * FROM enrollments WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToEnrollment($data) : null;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM enrollments WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM enrollments");
        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToEnrollment'], $enrollments);
    }

    private function mapToEnrollment(array $data): Enrollment
    {
        $enrollment = new Enrollment(
            (int) $data['student_id'],
            (int) $data['subject_id'],
            new \DateTime($data['enrollment_date'])
        );
        $enrollment->setId((int) $data['id']);

        return $enrollment;
    }
}
