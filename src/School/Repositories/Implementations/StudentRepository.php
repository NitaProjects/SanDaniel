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
        $stmt = $this->db->prepare("SELECT id FROM users WHERE id = :user_id AND user_type = 'student'");
        $stmt->bindValue(':user_id', $student->getUserId());
        $stmt->execute();

        if (!$stmt->fetch()) {
            throw new \InvalidArgumentException("Cannot create a student without an existing user of type 'student'.");
        }

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
        $stmt = $this->db->prepare("
            SELECT 
                students.id AS student_id,
                students.dni,
                students.enrollment_year,
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                users.password,
                users.user_type
            FROM students
            INNER JOIN users ON students.user_id = users.id
            WHERE students.id = :id
        ");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToStudent($data) : null;
    }

    public function findByDni(string $dni): ?Student
    {
        $stmt = $this->db->prepare("
            SELECT 
                students.id AS student_id,
                students.dni,
                students.enrollment_year,
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                users.password,
                users.user_type
            FROM students
            INNER JOIN users ON students.user_id = users.id
            WHERE students.dni = :dni
        ");
        $stmt->bindValue(':dni', $dni);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToStudent($data) : null;
    }

    public function findByUserId(int $userId): ?Student
    {
        $stmt = $this->db->prepare("
            SELECT 
                students.id AS student_id,
                students.dni,
                students.enrollment_year,
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                users.password,
                users.user_type
            FROM students
            INNER JOIN users ON students.user_id = users.id
            WHERE users.id = :user_id
        ");
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToStudent($data) : null;
    }

    public function findByEnrollmentYear(int $year): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                students.id AS student_id,
                students.dni,
                students.enrollment_year,
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                users.password,
                users.user_type
            FROM students
            INNER JOIN users ON students.user_id = users.id
            WHERE students.enrollment_year = :year
        ");
        $stmt->bindValue(':year', $year);
        $stmt->execute();

        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToStudent'], $students);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                students.id AS student_id,
                students.dni,
                students.enrollment_year,
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                users.password,
                users.user_type
            FROM students
            INNER JOIN users ON students.user_id = users.id
        ");
        $stmt->execute();

        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToStudent'], $students);
    }

    private function mapToStudent(array $data): Student
    {
        $student = new Student(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['password'],
            'student',
            $data['dni'],
            (int)$data['enrollment_year'],
            (int)$data['user_id']
        );
        $student->setId((int)$data['student_id']);

        return $student;
    }
}
