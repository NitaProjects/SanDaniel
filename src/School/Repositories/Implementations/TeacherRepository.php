<?php

namespace App\School\Repositories\Implementations;

use App\School\Repositories\Interfaces\ITeacherRepository;
use App\School\Entities\Teacher;
use PDO;

class TeacherRepository implements ITeacherRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Agregar un nuevo profesor
    public function add(Teacher $teacher): void
    {
        // Verificar que el user_id existe y es de tipo 'teacher'
        $stmt = $this->db->prepare("SELECT id FROM users WHERE id = :user_id AND user_type = 'teacher'");
        $stmt->bindValue(':user_id', $teacher->getUserId(), PDO::PARAM_INT);
        $stmt->execute();

        if (!$stmt->fetch()) {
            throw new \InvalidArgumentException("Cannot add a teacher without an existing user of type 'teacher'.");
        }

        // Insertar el registro en la tabla `teachers`
        $stmt = $this->db->prepare("
        INSERT INTO teachers (user_id)
        VALUES (:user_id)
    ");
        $stmt->bindValue(':user_id', $teacher->getUserId(), PDO::PARAM_INT);
        $stmt->execute();

        // Establecer el ID del profesor generado
        $teacher->setId((int)$this->db->lastInsertId());
    }


    // Actualizar un profesor existente
    public function update(Teacher $teacher): void
    {
        $stmt = $this->db->prepare("
            UPDATE teachers SET 
                user_id = :user_id
            WHERE id = :id
        ");
        $stmt->bindValue(':id', $teacher->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $teacher->getUserId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findById(int $id): ?Teacher
    {
        $stmt = $this->db->prepare("
            SELECT 
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                teachers.id AS teacher_id
            FROM teachers
            INNER JOIN users ON teachers.user_id = users.id
            WHERE teachers.id = :id
        ");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToTeacher($data) : null;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM teachers WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAll(): array
{
    $stmt = $this->db->prepare("
        SELECT 
            users.id AS user_id,
            users.first_name,
            users.last_name,
            users.email,
            teachers.id AS teacher_id
        FROM teachers
        INNER JOIN users ON teachers.user_id = users.id
    ");
    $stmt->execute();

    $rawData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mapear cada fila a un objeto Teacher
    return array_map([$this, 'mapToTeacher'], $rawData);
}


    public function getDepartments(int $teacherId): array
    {
        $stmt = $this->db->prepare("
            SELECT d.id, d.name 
            FROM departments d
            INNER JOIN teacher_departments td ON d.id = td.department_id
            WHERE td.teacher_id = :teacher_id
        ");
        $stmt->bindValue(':teacher_id', $teacherId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignDepartment(int $teacherId, int $departmentId): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO teacher_departments (teacher_id, department_id)
            VALUES (:teacher_id, :department_id)
        ");
        $stmt->bindValue(':teacher_id', $teacherId, PDO::PARAM_INT);
        $stmt->bindValue(':department_id', $departmentId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removeDepartment(int $teacherId, int $departmentId): void
    {
        $stmt = $this->db->prepare("
            DELETE FROM teacher_departments 
            WHERE teacher_id = :teacher_id AND department_id = :department_id
        ");
        $stmt->bindValue(':teacher_id', $teacherId, PDO::PARAM_INT);
        $stmt->bindValue(':department_id', $departmentId, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function mapToTeacher(array $data): Teacher
    {
        $teacher = new Teacher(
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['email'] ?? '',
            '', 
            $data['user_id'] ?? 0, 
            $this->getDepartments($data['teacher_id']) 
        );

        $teacher->setId($data['teacher_id']);

        return $teacher;
    }
}
