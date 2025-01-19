<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\IExamRepository;
use App\School\Entities\Exam;

class ExamService
{
    private IExamRepository $examRepository;

    public function __construct(IExamRepository $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    /**
     * Crear un nuevo examen.
     */
    public function addExam(int $subjectId, \DateTime $examDate, string $description): Exam
    {
        $exam = new Exam($subjectId, $examDate, $description);
        $this->examRepository->add($exam);

        return $exam;
    }

    /**
     * Actualizar un examen existente.
     */
    public function updateExam(int $id, int $subjectId, \DateTime $examDate, string $description): void
    {
        $exam = $this->getExamById($id);

        if (!$exam) {
            throw new \Exception("Exam with ID $id not found.");
        }

        $exam->setSubjectId($subjectId)
             ->setExamDate($examDate)
             ->setDescription($description);

        $this->examRepository->update($exam);
    }

    /**
     * Obtener un examen por su ID.
     */
    public function getExamById(int $id): ?Exam
    {
        return $this->examRepository->findById($id);
    }

    /**
     * Eliminar un examen.
     */
    public function deleteExam(int $id): void
    {
        $this->examRepository->delete($id);
    }

    /**
     * Obtener todos los exámenes.
     */
    public function getAllExams(): array
    {
        return $this->examRepository->getAll();
    }
}
