<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Exam;
use App\School\Repositories\Interfaces\IExamRepository;
use PDO;

class ExamRepository implements IExamRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function save(Exam $exam): void
    {
        if ($exam->getId()) {
            $stmt = $this->db->prepare("
                UPDATE exams SET 
                    subject_id = :subject_id,
                    description = :description,
                    exam_date = :exam_date
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $exam->getId());
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO exams (subject_id, description, exam_date)
                VALUES (:subject_id, :description, :exam_date)
            ");
        }

        $stmt->bindValue(':subject_id', $exam->getSubjectId());
        $stmt->bindValue(':description', $exam->getDescription());
        $stmt->bindValue(':exam_date', $exam->getExamDate()->format('Y-m-d'));
        $stmt->execute();
    }

    public function findById(int $id): ?Exam
    {
        $stmt = $this->db->prepare("SELECT * FROM exams WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToExam($data) : null;
    }

    public function findBySubjectId(int $subjectId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM exams WHERE subject_id = :subject_id");
        $stmt->bindValue(':subject_id', $subjectId);
        $stmt->execute();

        $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToExam'], $exams);
    }

    public function findByDescription(string $description): array
    {
        $stmt = $this->db->prepare("SELECT * FROM exams WHERE description LIKE :description");
        $stmt->bindValue(':description', "%$description%");
        $stmt->execute();

        $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToExam'], $exams);
    }

    public function findByExamDate(\DateTime $examDate): array
    {
        $stmt = $this->db->prepare("SELECT * FROM exams WHERE exam_date = :exam_date");
        $stmt->bindValue(':exam_date', $examDate->format('Y-m-d'));
        $stmt->execute();

        $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToExam'], $exams);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM exams WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM exams");
        $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToExam'], $exams);
    }

    private function mapToExam(array $data): Exam
    {
        $exam = new Exam(
            (int) $data['subject_id'],
            new \DateTime($data['exam_date']),
            $data['description']
        );
        $exam->setId((int) $data['id']);

        return $exam;
    }
}
