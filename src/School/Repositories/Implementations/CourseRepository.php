<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Course;
use App\School\Entities\Degree;
use App\School\Repositories\Interfaces\ICourseRepository;
use App\School\Repositories\Implementations\DegreeRepository;
use PDO;

class CourseRepository implements ICourseRepository
{
    private PDO $db;
    private DegreeRepository $degreeRepo;

    public function __construct(PDO $db, DegreeRepository $degreeRepo)
    {
        $this->db = $db;
        $this->degreeRepo = $degreeRepo;
    }

    public function save(Course $course): void
    {
        if ($course->getId()) {
            $stmt = $this->db->prepare("
                UPDATE courses SET 
                    name = :name,
                    degree_id = :degree_id
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $course->getId());
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO courses (name, degree_id)
                VALUES (:name, :degree_id)
            ");
        }

        $stmt->bindValue(':name', $course->getName());
        $stmt->bindValue(':degree_id', $course->getDegree() ? $course->getDegree()->getId() : null);
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
        $course = new Course($data['name']);
        $course->setId($data['id']);

        // Asociar la titulación si existe
        if (!empty($data['degree_id'])) {
            $degree = $this->degreeRepo->findById($data['degree_id']);
            if ($degree) {
                $course->setDegree($degree);
            }
        }

        return $course;
    }
}
