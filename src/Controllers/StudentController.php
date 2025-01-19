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

    /**
     * Agregar un nuevo estudiante.
     */
    public function addStudent(Request $request): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['user_id'], $data['dni'], $data['enrollment_year'])) {
                throw new \InvalidArgumentException("user_id, dni, and enrollment_year are required.");
            }

            $student = $this->studentService->addStudent(
                (int)$data['user_id'],
                $data['dni'],
                (int)$data['enrollment_year']
            );

            http_response_code(201);
            echo json_encode([
                'id' => $student->getId(),
                'user_id' => $student->getUserId(),
                'dni' => $student->getDni(),
                'enrollment_year' => $student->getEnrollmentYear()
            ]);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener un estudiante por su ID.
     */
    public function getStudentById(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $student = $this->studentService->getStudentById($id);

            if ($student) {
                http_response_code(200);
                echo json_encode([
                    'id' => $student->getId(),
                    'user_id' => $student->getUserId(),
                    'dni' => $student->getDni(),
                    'enrollment_year' => $student->getEnrollmentYear()
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Student not found']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener todos los estudiantes.
     */
    public function getAllStudents(): void
    {
        try {
            $students = $this->studentService->getAllStudents();

            http_response_code(200);
            echo json_encode(array_map(fn($student) => [
                'id' => $student->getId(),
                'user_id' => $student->getUserId(),
                'dni' => $student->getDni(),
                'enrollment_year' => $student->getEnrollmentYear()
            ], $students));
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Eliminar un estudiante por su ID.
     */
    public function deleteStudent(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $this->studentService->deleteStudent($id);

            http_response_code(204);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }
}
