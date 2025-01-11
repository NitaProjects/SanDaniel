<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Student;
use App\School\Repositories\Interfaces\IStudentRepository;
use PDO;

class StudentRepository implements IStudentRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Student $student): void
    {
        if ($student->getId()) {
            $stmt = $this->db->prepare("
                UPDATE students SET 
                    user_id = :user_id,
                    dni = :dni,
                    enrollment_year = :enrollment_year
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $student->getId());
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO students (user_id, dni, enrollment_year)
                VALUES (:user_id, :dni, :enrollment_year)
            ");
        }

        $stmt->bindValue(':user_id', $student->getUserId());
        $stmt->bindValue(':dni', $student->getDni());
        $stmt->bindValue(':enrollment_year', $student->getEnrollmentYear());
        $stmt->execute();
    }

    public function findById(int $id): ?Student
    {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToStudent($data) : null;
    }

    public function findByDni(string $dni): ?Student
    {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE dni = :dni");
        $stmt->bindValue(':dni', $dni);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToStudent($data) : null;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM students");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToStudent'], $students);
    }

    private function mapToStudent(array $data): Student
    {
        $student = new Student(
            $data['user_id'],
            $data['dni'],
            $data['enrollment_year']
        );
        $student->setId($data['id']);
        return $student;
    }
}
