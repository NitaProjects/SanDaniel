<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Subject;
use App\School\Repositories\Interfaces\ISubjectRepository;
use PDO;

class SubjectRepository implements ISubjectRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
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
        $stmt->bindValue(':course_id', $subject->getCourseId());
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

    public function findByName(string $name): array
    {
        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE name LIKE :name");
        $stmt->bindValue(':name', "%$name%");
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
    $subject = new Subject($data['name'], $data['course_id']); 
    $subject->setId($data['id']); 

    return $subject;
}

}
