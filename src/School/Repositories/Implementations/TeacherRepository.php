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
        $this->departmentRepo = $departmentRepo; // Inicializa el repositorio de departamentos
    }

    public function save(Teacher $teacher): void
    {
        if ($teacher->getId()) {
            $stmt = $this->db->prepare("
                UPDATE teachers SET 
                    user_id = :user_id,
                    department_id = :department_id
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $teacher->getId());
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO teachers (user_id, department_id)
                VALUES (:user_id, :department_id)
            ");
        }

        $stmt->bindValue(':user_id', $teacher->getUserId());
        $stmt->bindValue(':department_id', $teacher->getDepartment() ? $teacher->getDepartment()->getId() : null);
        $stmt->execute();
    }

    public function findById(int $id): ?Teacher
    {
        $stmt = $this->db->prepare("SELECT * FROM teachers WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToTeacher($data) : null;
    }

    public function findByUserId(int $userId): ?Teacher
    {
        $stmt = $this->db->prepare("SELECT * FROM teachers WHERE user_id = :user_id");
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

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM teachers");
        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToTeacher'], $teachers);
    }

    private function mapToTeacher(array $data): Teacher
    {
        // Consulta los datos del usuario
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->bindValue(':user_id', $data['user_id']);
        $stmt->execute();

        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            throw new \Exception("User not found for user_id: " . $data['user_id']);
        }

        $teacher = new Teacher(
            $userData['first_name'],
            $userData['last_name'],
            $userData['email'],
            $userData['password'],
            $userData['user_type']
        );

        $teacher->setId($data['id']);
        $teacher->setUserId($data['user_id']);

        // Asociar el departamento si existe
        if (!empty($data['department_id'])) {
            $department = $this->departmentRepo->findById($data['department_id']);
            if ($department) {
                $teacher->addToDepartment($department);
            }
        }

        return $teacher;
    }
}
