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
        $stmt = $this->db->prepare("SELECT id FROM users WHERE id = :user_id AND user_type = 'teacher'");
        $stmt->bindValue(':user_id', $teacher->getUserId(), PDO::PARAM_INT);
        $stmt->execute();

        if (!$stmt->fetch()) {
            throw new \InvalidArgumentException("Cannot add a teacher without an existing user of type 'teacher'.");
        }

        $stmt = $this->db->prepare("INSERT INTO teachers (user_id) VALUES (:user_id)");
        $stmt->bindValue(':user_id', $teacher->getUserId(), PDO::PARAM_INT);
        $stmt->execute();

        $teacher->setId((int)$this->db->lastInsertId());
    }

    // Actualizar un profesor existente
    public function update(Teacher $teacher): void
    {
        $stmt = $this->db->prepare("UPDATE teachers SET user_id = :user_id WHERE id = :id");
        $stmt->bindValue(':id', $teacher->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $teacher->getUserId(), PDO::PARAM_INT);
        $stmt->execute();
    }

    // Eliminar un profesor por su ID, incluyendo asignaciones en cascada
    public function delete(int $id): void
    {
        $this->db->beginTransaction();
        try {
            // Eliminar asignaciones en teacher_departments
            $stmt = $this->db->prepare("DELETE FROM teacher_departments WHERE teacher_id = :teacher_id");
            $stmt->bindValue(':teacher_id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Eliminar profesor
            $stmt = $this->db->prepare("DELETE FROM teachers WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Encontrar un profesor por su ID
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

    // Obtener todos los profesores
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
        return array_map([$this, 'mapToTeacher'], $rawData);
    }

    // Obtener todas las asignaciones de profesores a departamentos
    public function getTeacherDepartments(): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                td.teacher_id,
                CONCAT(u.first_name, ' ', u.last_name) AS teacher,
                d.id AS department_id,
                d.name AS department
            FROM teacher_departments td
            INNER JOIN teachers t ON td.teacher_id = t.id
            INNER JOIN users u ON t.user_id = u.id
            INNER JOIN departments d ON td.department_id = d.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Asignar un departamento a un profesor
    public function assignDepartment(int $teacherId, int $departmentId): void
    {


        $stmt = $this->db->prepare("
        INSERT INTO teacher_departments (teacher_id, department_id)
        VALUES (:teacher_id, :department_id)
    ");
        $stmt->bindValue(':teacher_id', $teacherId, PDO::PARAM_INT);
        $stmt->bindValue(':department_id', $departmentId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new \Exception("Error al asignar el departamento en la base de datos.");
        }
    }



    // Eliminar un departamento asignado a un profesor
    public function removeDepartment(int $teacherId, int $departmentId): void
    {
        error_log("Intentando eliminar: teacher_id = $teacherId, department_id = $departmentId");

        $stmt = $this->db->prepare("
        DELETE FROM teacher_departments 
        WHERE teacher_id = :teacher_id AND department_id = :department_id
    ");
        $stmt->bindValue(':teacher_id', $teacherId, PDO::PARAM_INT);
        $stmt->bindValue(':department_id', $departmentId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            error_log("Eliminación exitosa de teacher_departments");
        } else {
            error_log("Error al eliminar de teacher_departments");
        }
    }


    // Mapear datos de la base de datos a un objeto Teacher
    private function mapToTeacher(array $data): Teacher
    {
        $teacher = new Teacher(
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            $data['email'] ?? '',
            '',
            $data['user_id'] ?? 0
        );

        $teacher->setId($data['teacher_id']);
        return $teacher;
    }
}
