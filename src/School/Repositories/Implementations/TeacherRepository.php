<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Teacher;
use App\School\Repositories\Interfaces\ITeacherRepository;
use App\School\Repositories\Implementations\DepartmentRepository;
use PDO;

class TeacherRepository implements ITeacherRepository
{
    private PDO $db;
    private DepartmentRepository $departmentRepo;

    public function __construct(PDO $db, DepartmentRepository $departmentRepo)
    {
        $this->db = $db;
        $this->departmentRepo = $departmentRepo;
    }

    public function save(Teacher $teacher): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO teachers (user_id, department_id)
            VALUES (:user_id, :department_id)"
        );

        $stmt->bindValue(':user_id', $teacher->getUserId());
        $stmt->bindValue(':department_id', $teacher->getDepartment() ? $teacher->getDepartment()->getId() : null);
        $stmt->execute();
    }

    public function findById(int $id): ?Teacher
    {
        $stmt = $this->db->prepare(
            "SELECT 
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                users.password,
                users.user_type,
                teachers.id AS teacher_id,
                teachers.department_id
            FROM teachers
            INNER JOIN users ON teachers.user_id = users.id
            WHERE teachers.id = :id"
        );
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToTeacher($data) : null;
    }

    public function findByUserId(int $userId): ?Teacher
    {
        $stmt = $this->db->prepare(
            "SELECT 
                users.id AS user_id, 
                users.first_name, 
                users.last_name, 
                users.email, 
                users.password, 
                users.user_type, 
                teachers.id AS teacher_id, 
                teachers.department_id 
            FROM users
            LEFT JOIN teachers ON users.id = teachers.user_id
            WHERE users.id = :user_id"
        );
        $stmt->bindValue(':user_id', $userId);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToTeacher($data) : null;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM teachers WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function deleteByTeacherAndDepartment(int $teacherId, int $departmentId): void
{
    $stmt = $this->db->prepare(
        "DELETE FROM teachers WHERE user_id = :teacher_id AND department_id = :department_id"
    );
    $stmt->bindValue(':teacher_id', $teacherId);
    $stmt->bindValue(':department_id', $departmentId);
    $stmt->execute();
}


    public function getAll(): array
    {
        $stmt = $this->db->prepare(
            "SELECT 
                users.id AS user_id, 
                users.first_name, 
                users.last_name, 
                users.email, 
                users.password, 
                users.user_type, 
                teachers.id AS teacher_id, 
                teachers.department_id 
            FROM users
            LEFT JOIN teachers ON users.id = teachers.user_id
            WHERE users.user_type = 'teacher'"
        );
        $stmt->execute();

        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToTeacher'], $teachers);
    }

    private function mapToTeacher(array $data): Teacher
    {
        $teacher = new Teacher(
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? '',
            $data['user_type'] ?? ''
        );

        $teacher->setId($data['teacher_id'] ?? null);
        $teacher->setUserId($data['user_id'] ?? null);

        if (!empty($data['department_id'])) {
            $department = $this->departmentRepo->findById($data['department_id']);
            if ($department) {
                $teacher->addToDepartment($department);
            }
        }

        return $teacher;
    }
}
