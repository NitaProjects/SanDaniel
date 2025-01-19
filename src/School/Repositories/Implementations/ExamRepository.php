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

    /**
     * Agregar un nuevo examen.
     */
    public function add(Exam $exam): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO exams (subject_id, description, exam_date)
            VALUES (:subject_id, :description, :exam_date)
        ");

        $stmt->bindValue(':subject_id', $exam->getSubjectId());
        $stmt->bindValue(':description', $exam->getDescription());
        $stmt->bindValue(':exam_date', $exam->getExamDate()->format('Y-m-d'));
        $stmt->execute();

        $exam->setId((int) $this->db->lastInsertId());
    }

    /**
     * Actualizar un examen existente.
     */
    public function update(Exam $exam): void
    {
        $stmt = $this->db->prepare("
            UPDATE exams SET 
                subject_id = :subject_id,
                description = :description,
                exam_date = :exam_date
            WHERE id = :id
        ");

        $stmt->bindValue(':id', $exam->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':subject_id', $exam->getSubjectId(), PDO::PARAM_INT);
        $stmt->bindValue(':description', $exam->getDescription());
        $stmt->bindValue(':exam_date', $exam->getExamDate()->format('Y-m-d'));
        $stmt->execute();
    }

    /**
     * Buscar un examen por su ID.
     */
    public function findById(int $id): ?Exam
    {
        $stmt = $this->db->prepare("SELECT * FROM exams WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToExam($data) : null;
    }

    /**
     * Eliminar un examen por su ID.
     */
    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM exams WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Obtener todos los exámenes.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM exams");
        $exams = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToExam'], $exams);
    }

    /**
     * Mapear un array a una entidad `Exam`.
     */
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
