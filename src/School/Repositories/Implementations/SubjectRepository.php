<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Subject;
use App\School\Repositories\Interfaces\ISubjectRepository;
use App\School\Repositories\Implementations\CourseRepository;
use PDO;

class SubjectRepository implements ISubjectRepository
{
    private PDO $db;
    private CourseRepository $courseRepo;

    public function __construct(PDO $db, CourseRepository $courseRepo)
    {
        $this->db = $db;
        $this->courseRepo = $courseRepo;
    }

    public function save(Subject $subject): void
    {
        if ($subject->getId()) {
            $stmt = $this->db->prepare("
                UPDATE subjects SET 
                    name = :name,
                    course_id = :course_id
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $subject->getId());
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO subjects (name, course_id)
                VALUES (:name, :course_id)
            ");
        }

        $stmt->bindValue(':name', $subject->getName());
        $stmt->bindValue(':course_id', $subject->getCourse() ? $subject->getCourse()->getId() : null);
        $stmt->execute();
    }

    public function findById(int $id): ?Subject
    {
        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToSubject($data) : null;
    }

    public function findByCourseId(int $courseId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE course_id = :course_id");
        $stmt->bindValue(':course_id', $courseId);
        $stmt->execute();

        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToSubject'], $subjects);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM subjects WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM subjects");
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToSubject'], $subjects);
    }

    private function mapToSubject(array $data): Subject
    {
        $subject = new Subject($data['name']);
        $subject->setId($data['id']);

        if (!empty($data['course_id'])) {
            $course = $this->courseRepo->findById($data['course_id']);
            if ($course) {
                $subject->setCourse($course);
            }
        }

        return $subject;
    }
}
