<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Student;
use App\School\Entities\Subject;
use App\School\Entities\Enrollment;
use App\School\Repositories\Interfaces\IStudentRepository;
use App\School\Repositories\Implementations\SubjectRepository;
use App\School\Repositories\Implementations\EnrollmentRepository;
use PDO;

class StudentRepository implements IStudentRepository
{
    private PDO $db;
    private SubjectRepository $subjectRepo;
    private ?EnrollmentRepository $enrollmentRepo = null;

    public function __construct(PDO $db, SubjectRepository $subjectRepo, ?EnrollmentRepository $enrollmentRepo = null)
    {
        $this->db = $db;
        $this->subjectRepo = $subjectRepo;
        $this->enrollmentRepo = $enrollmentRepo;
    }

    public function setEnrollmentRepository(EnrollmentRepository $enrollmentRepository): void
    {
        $this->enrollmentRepo = $enrollmentRepository;
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
            users.id AS user_id, 
            users.first_name, 
            users.last_name, 
            users.email, 
            users.password, 
            users.user_type, 
            students.dni, 
            students.enrollment_year 
        FROM students
        INNER JOIN users ON students.user_id = users.id
        WHERE users.user_type = 'student'
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

        // Cargar enrollments y asociar asignaturas
        $stmt = $this->db->prepare("
        SELECT e.*, s.name AS subject_name 
        FROM enrollments e 
        JOIN subjects s ON e.subject_id = s.id
        WHERE e.student_id = :student_id
    ");
        $stmt->bindValue(':student_id', $data['student_id']);
        $stmt->execute();

        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($enrollments as $enrollmentData) {
            $subject = new Subject($enrollmentData['subject_name']);
            $subject->setId($enrollmentData['subject_id']);

            $enrollment = new Enrollment($student, $subject, new \DateTime($enrollmentData['enrollment_date']));
            $enrollment->setId($enrollmentData['id']);

            $student->addEnrollment($enrollment);
        }

        return $student;
    }
}
