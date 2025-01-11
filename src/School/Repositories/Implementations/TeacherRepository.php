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
            $stmt = $this->db->prepare(""
                . "UPDATE teachers SET \n"
                . "    user_id = :user_id,\n"
                . "    department_id = :department_id\n"
                . "WHERE id = :id"
            );
            $stmt->bindValue(':id', $teacher->getId());
        } else {
            $stmt = $this->db->prepare(""
                . "INSERT INTO teachers (user_id, department_id)\n"
                . "VALUES (:user_id, :department_id)"
            );
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
        $stmt = $this->db->prepare(""
            . "SELECT \n"
            . "    users.id AS user_id, \n"
            . "    users.first_name, \n"
            . "    users.last_name, \n"
            . "    users.email, \n"
            . "    users.password, \n"
            . "    users.user_type, \n"
            . "    teachers.id AS teacher_id, \n"
            . "    teachers.department_id \n"
            . "FROM users\n"
            . "LEFT JOIN teachers ON users.id = teachers.user_id\n"
            . "WHERE users.user_type = 'teacher'"
        );
        $stmt->execute();

        $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToTeacher'], $teachers);
    }

    private function mapToTeacher(array $data): Teacher
    {
        $teacher = new Teacher(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['password'],
            $data['user_type']
        );

        $teacher->setId($data['teacher_id'] ?? null);
        $teacher->setUserId($data['user_id']);

        // Asocia el departamento si existe
        if (!empty($data['department_id'])) {
            $department = $this->departmentRepo->findById($data['department_id']);
            if ($department) {
                $teacher->addToDepartment($department);
            }
        }

        return $teacher;
    }
}
