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

    /**
     * Crear un nuevo examen.
     */
    public function addExam(Request $request): void
    {
        try {
            $body = $request->getBody();

            if (!isset($body['subjectId'], $body['examDate'], $body['description'])) {
                throw new \InvalidArgumentException("All fields are required: subjectId, examDate, and description.");
            }

            $exam = $this->examService->addExam(
                (int)$body['subjectId'],
                new \DateTime($body['examDate']),
                $body['description']
            );

            http_response_code(201); // Created
            echo json_encode([
                'message' => 'Exam created successfully',
                'id' => $exam->getId(),
            ]);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Actualizar un examen existente.
     */
    public function updateExam(Request $request): void
    {
        try {
            $body = $request->getBody();

            if (!isset($body['id'], $body['subjectId'], $body['examDate'], $body['description'])) {
                throw new \InvalidArgumentException("All fields are required: id, subjectId, examDate, and description.");
            }

            $this->examService->updateExam(
                (int)$body['id'],
                (int)$body['subjectId'],
                new \DateTime($body['examDate']),
                $body['description']
            );

            http_response_code(200); // OK
            echo json_encode(['message' => 'Exam updated successfully']);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener un examen por su ID.
     */
    public function getExamById(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];

            $exam = $this->examService->getExamById($id);

            if (!$exam) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'Exam not found']);
                return;
            }

            http_response_code(200); // OK
            echo json_encode($exam);
        } catch (\Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener todos los exámenes.
     */
    public function getAllExams(): void
    {
        try {
            $exams = $this->examService->getAllExams();
            http_response_code(200); // OK
            echo json_encode($exams);
        } catch (\Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Eliminar un examen por su ID.
     */
    public function deleteExam(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $this->examService->deleteExam($id);

            http_response_code(204); // No Content
        } catch (\Exception $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }
}
