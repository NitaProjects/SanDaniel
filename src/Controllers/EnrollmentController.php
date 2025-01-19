<?php

namespace App\Controllers;

use App\School\Services\EnrollmentService;
use App\Infrastructure\Routing\Request;

class EnrollmentController
{
    private EnrollmentService $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * Añadir una nueva matrícula.
     */
    public function add(Request $request): void
    {
        try {
            $body = $request->getBody();

            if (!isset($body['studentId'], $body['subjectId'], $body['enrollmentDate'])) {
                throw new \InvalidArgumentException("All fields (studentId, subjectId, enrollmentDate) are required.");
            }

            $this->enrollmentService->addEnrollment(
                (int)$body['studentId'],
                (int)$body['subjectId'],
                new \DateTime($body['enrollmentDate'])
            );

            http_response_code(201); // Created
            echo json_encode(['message' => 'Enrollment added successfully']);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Actualizar una matrícula existente.
     */
    public function update(Request $request): void
    {
        try {
            $body = $request->getBody();

            if (!isset($body['id'], $body['studentId'], $body['subjectId'], $body['enrollmentDate'])) {
                throw new \InvalidArgumentException("All fields (id, studentId, subjectId, enrollmentDate) are required.");
            }

            $this->enrollmentService->updateEnrollment(
                (int)$body['id'],
                (int)$body['studentId'],
                (int)$body['subjectId'],
                new \DateTime($body['enrollmentDate'])
            );

            http_response_code(200); // OK
            echo json_encode(['message' => 'Enrollment updated successfully']);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener una matrícula por su ID.
     */
    public function getById(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];
            $enrollment = $this->enrollmentService->getEnrollmentById($id);

            if (!$enrollment) {
                http_response_code(404);
                echo json_encode(['error' => 'Enrollment not found.']);
                return;
            }

            http_response_code(200); // OK
            echo json_encode($enrollment);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Obtener todas las matrículas.
     */
    public function getAll(): void
    {
        try {
            $enrollments = $this->enrollmentService->getAllEnrollments();

            http_response_code(200); // OK
            echo json_encode($enrollments);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Eliminar una matrícula por ID.
     */
    public function delete(Request $request): void
    {
        try {
            $id = (int)$request->getQueryParams()['id'];

            $this->enrollmentService->deleteEnrollment($id);

            http_response_code(204); // No Content
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }
}
