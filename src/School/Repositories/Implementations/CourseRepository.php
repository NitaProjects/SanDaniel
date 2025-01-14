<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Course;
use App\School\Repositories\Interfaces\ICourseRepository;
use PDO;

class CourseRepository implements ICourseRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Course $course): void
    {
        if ($course->getId()) {
            // Actualizar curso existente
            $stmt = $this->db->prepare("
                UPDATE courses SET 
                    name = :name,
                    degree_id = :degree_id
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $course->getId());
        } else {
            // Crear nuevo curso
            $stmt = $this->db->prepare("
                INSERT INTO courses (name, degree_id)
                VALUES (:name, :degree_id)
            ");
        }

        $stmt->bindValue(':name', $course->getName());
        $stmt->bindValue(':degree_id', $course->getDegreeId());
        $stmt->execute();
    }

    public function findById(int $id): ?Course
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToCourse($data) : null;
    }

    public function findByDegreeId(int $degreeId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE degree_id = :degree_id");
        $stmt->bindValue(':degree_id', $degreeId);
        $stmt->execute();

        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToCourse'], $courses);
    }

    public function findByName(string $name): array
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE name LIKE :name");
        $stmt->bindValue(':name', "%$name%");
        $stmt->execute();

        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToCourse'], $courses);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM courses");
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToCourse'], $courses);
    }

    private function mapToCourse(array $data): Course
    {
        $course = new Course($data['name'], $data['degree_id']);
        $course->setId($data['id']);
        return $course;
    }
}
