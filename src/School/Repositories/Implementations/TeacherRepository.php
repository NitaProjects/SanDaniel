<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Teacher;
use App\School\Repositories\Interfaces\ITeacherRepository;
use PDO;

class TeacherRepository implements ITeacherRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Teacher $teacher): void
    {
        // Verificar si el usuario existe antes de guardar el profesor
        $stmt = $this->db->prepare("SELECT id FROM users WHERE id = :user_id AND user_type = 'teacher'");
        $stmt->bindValue(':user_id', $teacher->getUserId());
        $stmt->execute();

        if (!$stmt->fetch()) {
            throw new \InvalidArgumentException("Cannot create a teacher without an existing user of type 'teacher'.");
        }

        if ($teacher->getId()) {
            // Actualizar registro existente
            $stmt = $this->db->prepare("
                UPDATE teachers SET 
                    user_id = :user_id
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $teacher->getId());
        } else {
            // Crear nuevo registro
            $stmt = $this->db->prepare("
                INSERT INTO teachers (user_id)
                VALUES (:user_id)
            ");
        }

        $stmt->bindValue(':user_id', $teacher->getUserId());
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
                users.password,
                users.user_type,
                teachers.id AS teacher_id
            FROM teachers
            INNER JOIN users ON teachers.user_id = users.id
            WHERE teachers.id = :id
        ");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToTeacher($data) : null;
    }

    public function findByUserId(int $userId): ?Teacher
    {
        $stmt = $this->db->prepare("
            SELECT 
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                users.password,
                users.user_type,
                teachers.id AS teacher_id
            FROM teachers
            INNER JOIN users ON teachers.user_id = users.id
            WHERE users.id = :user_id
        ");
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
        $stmt = $this->db->prepare("
            SELECT 
                users.id AS user_id,
                users.first_name,
                users.last_name,
                users.email,
                users.password,
                users.user_type,
                teachers.id AS teacher_id
            FROM teachers
            INNER JOIN users ON teachers.user_id = users.id
            WHERE users.user_type = 'teacher'
        ");
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
        );
        $teacher->setId($data['teacher_id']);
        $teacher->setUserId($data['user_id']);

        return $teacher;
    }
}
