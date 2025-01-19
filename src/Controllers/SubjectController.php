<?php

namespace App\Controllers;

use App\Infrastructure\Routing\Request;
use App\School\Services\SubjectService;

class SubjectController
{
    private SubjectService $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    /**
     * Crear una nueva asignatura.
     */
    public function createSubject(Request $request): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['name'], $data['course_id'])) {
                throw new \InvalidArgumentException("Name and course_id are required.");
            }

            $subject = $this->subjectService->createSubject($data['name'], (int)$data['course_id']);

            http_response_code(201);
            echo json_encode($subject);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    /**
     * Obtener una asignatura por su ID.
     */
    public function getSubjectById(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $subject = $this->subjectService->getSubjectById($id);

            if ($subject) {
                http_response_code(200);
                echo json_encode($subject);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Subject not found']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    /**
     * Actualizar una asignatura.
     */
    public function updateSubject(Request $request): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['id'], $data['name'], $data['course_id'])) {
                throw new \InvalidArgumentException("ID, name, and course_id are required.");
            }

            $this->subjectService->updateSubject((int)$data['id'], $data['name'], (int)$data['course_id']);

            http_response_code(200);
            echo json_encode(['message' => 'Subject updated successfully']);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    /**
     * Eliminar una asignatura por su ID.
     */
    public function deleteSubject(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $this->subjectService->deleteSubject($id);

            http_response_code(204);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    /**
     * Obtener todas las asignaturas.
     */
    public function getAllSubjects(): void
    {
        try {
            $subjects = $this->subjectService->getAllSubjects();

            http_response_code(200);
            echo json_encode($subjects);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }
}
