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

    public function getSubjectsByCourseId(Request $request): void
    {
        try {
            $courseId = (int)$request->getQueryParams()['course_id'];
            $subjects = $this->subjectService->findSubjectsByCourseId($courseId);

            http_response_code(200);
            echo json_encode($subjects);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

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
}
