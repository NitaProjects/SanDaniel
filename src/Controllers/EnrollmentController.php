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

    public function create(Request $request): void
    {
        $body = $request->getBody();
        $this->enrollmentService->createEnrollment(
            (int)$body['studentId'],
            (int)$body['subjectId'],
            new \DateTime($body['enrollmentDate'])
        );

        echo json_encode(['message' => 'Enrollment created successfully']);
    }

    public function update(Request $request): void
    {
        $body = $request->getBody();
        $this->enrollmentService->updateEnrollment(
            (int)$body['id'],
            (int)$body['studentId'],
            (int)$body['subjectId'],
            new \DateTime($body['enrollmentDate'])
        );

        echo json_encode(['message' => 'Enrollment updated successfully']);
    }

    public function getById(Request $request): void
    {
        $id = (int)$request->getQueryParams('id');
        $enrollment = $this->enrollmentService->getEnrollmentById($id);

        echo json_encode($enrollment);
    }

    public function getAll(): void
    {
        $enrollments = $this->enrollmentService->getAllEnrollments();
        echo json_encode($enrollments);
    }

    public function delete(Request $request): void
    {
        $id = (int)$request->getQueryParams('id');
        $this->enrollmentService->deleteEnrollment($id);

        echo json_encode(['message' => 'Enrollment deleted successfully']);
    }
}
