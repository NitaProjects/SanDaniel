<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Student;
use App\School\Entities\Course;
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
                    dni = :dni,
                    enrollment_year = :enrollment_year
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $student->getId());
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO students (dni, enrollment_year)
                VALUES (:dni, :enrollment_year)
            ");
        }

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
    $stmt = $this->db->query("
        SELECT 
            students.id AS student_id, 
            users.first_name, 
            users.last_name, 
            users.email, 
            users.password, 
            users.user_type, 
            students.dni, 
            students.enrollment_year 
        FROM students
        INNER JOIN users ON students.user_id = users.id
    ");
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
        $data['user_type'],
        $data['dni'],
        $data['enrollment_year']
    );

    $student->setId($data['student_id']);


    // Cargar enrollments y asociar cursos
    $stmt = $this->db->prepare("
        SELECT e.*, c.name AS course_name 
        FROM enrollments e 
        JOIN courses c ON e.subject_id = c.id
        WHERE e.student_id = :student_id
    ");
    $stmt->bindValue(':student_id', $data['student_id']);

    $stmt->execute();

    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($enrollments as $enrollmentData) {
        $course = new Course($enrollmentData['course_name']);
        $course->setId($enrollmentData['subject_id']); // ID del curso
        $student->addCourse($course);
    }

    return $student;
}


}
