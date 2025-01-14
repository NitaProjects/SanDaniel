<?php

namespace App\Controllers;

use App\Infrastructure\Routing\Request;
use App\School\Services\TeacherService;

class TeacherController
{
    private TeacherService $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function createTeacher(Request $request): void
    {
        try {
            $data = $request->getBody();
            if (!isset($data['user_id'])) {
                throw new \InvalidArgumentException("user_id is required");
            }

            $teacher = $this->teacherService->createTeacher((int)$data['user_id']);

            http_response_code(201);
            echo json_encode($teacher);
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
            $id = (int) $request->getQueryParams()['id'];
            $teacher = $this->teacherService->getTeacherById($id);

            if ($teacher) {
                http_response_code(200);
                echo json_encode($teacher);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Teacher not found']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getTeacherByUserId(Request $request): void
    {
        try {
            $userId = (int) $request->getQueryParams()['user_id'];
            $teacher = $this->teacherService->getTeacherByUserId($userId);

            if ($teacher) {
                http_response_code(200);
                echo json_encode($teacher);
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
            $id = (int) $request->getQueryParams()['id'];
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
            echo json_encode($teachers);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }
}
