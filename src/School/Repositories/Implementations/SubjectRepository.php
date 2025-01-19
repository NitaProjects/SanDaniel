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

    public function add(Subject $subject): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO subjects (name, course_id)
            VALUES (:name, :course_id)
        ");

        $stmt->bindValue(':name', $subject->getName());
        $stmt->bindValue(':course_id', $subject->getCourseId());
        $stmt->execute();

        $subject->setId((int)$this->db->lastInsertId());
    }

    public function update(Subject $subject): void
    {
        if (!$subject->getId()) {
            throw new \InvalidArgumentException("Subject ID is required for update.");
        }

        $stmt = $this->db->prepare("
            UPDATE subjects SET 
                name = :name,
                course_id = :course_id
            WHERE id = :id
        ");

        $stmt->bindValue(':id', $subject->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':name', $subject->getName());
        $stmt->bindValue(':course_id', $subject->getCourseId());
        $stmt->execute();
    }

    public function findById(int $id): ?Subject
    {
        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToSubject($data) : null;
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM subjects WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
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
        $subject = new Subject($data['name'], (int)$data['course_id']);
        $subject->setId((int)$data['id']);

        return $subject;
    }
}
