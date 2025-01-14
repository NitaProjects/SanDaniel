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

    public function createExam(int $subjectId, \DateTime $examDate, string $description): Exam
    {
        $exam = new Exam($subjectId, $examDate, $description);
        $this->examRepository->save($exam);

        return $exam;
    }

    public function updateExam(int $id, int $subjectId, \DateTime $examDate, string $description): void
    {
        $exam = $this->getExamById($id);

        if (!$exam) {
            throw new \Exception("Exam with ID $id not found.");
        }

        $exam->setSubjectId($subjectId)
             ->setExamDate($examDate)
             ->setDescription($description);

        $this->examRepository->save($exam);
    }

    public function getExamById(int $id): ?Exam
    {
        return $this->examRepository->findById($id);
    }

    public function getExamsBySubjectId(int $subjectId): array
    {
        return $this->examRepository->findBySubjectId($subjectId);
    }

    public function getExamsByDescription(string $description): array
    {
        return $this->examRepository->findByDescription($description);
    }

    public function getExamsByDate(\DateTime $examDate): array
    {
        return $this->examRepository->findByExamDate($examDate);
    }

    public function deleteExam(int $id): void
    {
        $this->examRepository->delete($id);
    }

    public function getAllExams(): array
    {
        return $this->examRepository->getAll();
    }
}
