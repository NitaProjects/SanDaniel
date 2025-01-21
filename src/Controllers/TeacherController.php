<?php

namespace App\Controllers;

use App\Infrastructure\Routing\Request;
use App\School\Services\TeacherService;
use App\School\Entities\Teacher;

class TeacherController
{
    private TeacherService $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    // -------------------------------
    // CRUD Básico
    // -------------------------------

    public function addTeacher(Request $request): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['user_id'])) {
                throw new \InvalidArgumentException("user_id is required");
            }

            $teacher = $this->teacherService->addTeacher((int)$data['user_id']);

            http_response_code(201);
            echo json_encode($this->serializeTeacher($teacher));
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function updateTeacher(Request $request): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['id'], $data['user_id'])) {
                throw new \InvalidArgumentException("id and user_id are required");
            }

            $this->teacherService->updateTeacher((int)$data['id'], (int)$data['user_id']);

            http_response_code(200);
            echo json_encode(['message' => 'Teacher updated successfully']);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getTeacherById(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $teacher = $this->teacherService->getTeacherById($id);

            if ($teacher) {
                http_response_code(200);
                echo json_encode($this->serializeTeacher($teacher));
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Teacher not found']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function deleteTeacher(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $this->teacherService->deleteTeacher($id);

            http_response_code(204);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getAllTeachers(): void
    {
        try {
            $teachers = $this->teacherService->getAllTeachers();

            http_response_code(200);
            echo json_encode(array_map([$this, 'serializeTeacher'], $teachers));
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Internal Server Error',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    // -------------------------------
    // Serialización
    // -------------------------------

    private function serializeTeacher(Teacher $teacher): array
    {
        return [
            'id' => $teacher->getId(),
            'first_name' => $teacher->getFirstName(),
            'last_name' => $teacher->getLastName(),
            'email' => $teacher->getEmail(),
        ];
    }
}
