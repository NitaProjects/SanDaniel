<?php

namespace App\School\Repositories\Implementations;

use App\School\Entities\Exam;
use App\School\Repositories\Interfaces\IExamRepository;
use App\School\Repositories\Implementations\SubjectRepository;
use PDO;

class ExamRepository implements IExamRepository
{
    private PDO $db;
    private SubjectRepository $subjectRepo;

    public function __construct(PDO $db, SubjectRepository $subjectRepo)
    {
        $this->db = $db;
        $this->subjectRepo = $subjectRepo;
    }

    public function save(Exam $exam): void
    {
        if ($exam->getId()) {
            $stmt = $this->db->prepare("
                UPDATE exams SET 
                    subject_id = :subject_id,
                    exam_date = :exam_date,
                    description = :description
                WHERE id = :id
            ");
            $stmt->bindValue(':id', $exam->getId());
        } else {
            $stmt = $this->db->prepare("
                INSERT INTO exams (subject_id, exam_date, description)
                VALUES (:subject_id, :exam_date, :description)
            ");
        }

        $stmt->bindValue(':subject_id', $exam->getSubject()->getId());
        $stmt->bindValue(':exam_date', $exam->getExamDate()->format('Y-m-d'));
        $stmt->bindValue(':description', $exam->getDescription());
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
        $subject = $this->subjectRepo->findById($data['subject_id']);

        if (!$subject) {
            throw new \Exception("Subject not found for subject_id: " . $data['subject_id']);
        }

        $exam = new Exam(
            $subject,
            new \DateTime($data['exam_date']),
            $data['description']
        );
        $exam->setId($data['id']);

        return $exam;
    }
}
