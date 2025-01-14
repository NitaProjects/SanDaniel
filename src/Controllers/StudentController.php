<?php

namespace App\Controllers;

use App\Infrastructure\Routing\Request;
use App\School\Services\StudentService;

class StudentController
{
    private StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function createStudent(Request $request): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['user_id'], $data['dni'], $data['enrollment_year'])) {
                throw new \InvalidArgumentException("user_id, dni, and enrollment_year are required.");
            }

            $student = $this->studentService->createStudent(
                (int)$data['user_id'],
                $data['dni'],
                (int)$data['enrollment_year']
            );

            http_response_code(201);
            echo json_encode($student);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getStudentById(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $student = $this->studentService->getStudentById($id);

            if ($student) {
                http_response_code(200);
                echo json_encode($student);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Student not found']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getStudentsByEnrollmentYear(Request $request): void
    {
        try {
            $year = (int)$request->getQueryParams()['enrollment_year'];
            $students = $this->studentService->getStudentsByEnrollmentYear($year);

            http_response_code(200);
            echo json_encode($students);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function deleteStudent(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $this->studentService->deleteStudent($id);

            http_response_code(204);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }
}
