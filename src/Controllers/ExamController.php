<?php

namespace App\Controllers;

use App\School\Services\ExamService;
use App\Infrastructure\Routing\Request;

class ExamController
{
    private ExamService $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function create(Request $request): void
    {
        $body = $request->getBody();
        $this->examService->createExam(
            (int)$body['subjectId'],
            new \DateTime($body['examDate']),
            $body['description']
        );

        echo json_encode(['message' => 'Exam created successfully']);
    }

    public function update(Request $request): void
    {
        $body = $request->getBody();
        $this->examService->updateExam(
            (int)$body['id'],
            (int)$body['subjectId'],
            new \DateTime($body['examDate']),
            $body['description']
        );

        echo json_encode(['message' => 'Exam updated successfully']);
    }

    public function getById(Request $request): void
    {
        $id = (int)$request->getQueryParams('id');
        $exam = $this->examService->getExamById($id);

        echo json_encode($exam);
    }

    public function getAll(): void
    {
        $exams = $this->examService->getAllExams();
        echo json_encode($exams);
    }

    public function delete(Request $request): void
    {
        $id = (int)$request->getQueryParams('id');
        $this->examService->deleteExam($id);

        echo json_encode(['message' => 'Exam deleted successfully']);
    }
}
