<?php

namespace App\Controllers;

use App\School\Services\CourseService;
use App\Infrastructure\Routing\Request;

class CourseController
{
    private CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function addCourse(Request $request): void
    {
        try {
            $data = $request->getBody();
            $name = $data['name'] ?? null;
            $degreeId = $data['degreeId'] ?? null;

            if (!$name || !$degreeId) {
                throw new \InvalidArgumentException("Name and degreeId are required.");
            }

            $course = $this->courseService->addCourse($name, (int)$degreeId);
            http_response_code(201); // Created
            echo json_encode([
                'id' => $course->getId(),
                'name' => $course->getName(),
                'degreeId' => $course->getDegreeId(),
            ]);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    public function getCourseById(Request $request, int $id): void
    {
        try {
            $course = $this->courseService->getCourseById($id);

            if (!$course) {
                http_response_code(404);
                echo json_encode(['error' => 'Course not found.']);
                return;
            }

            http_response_code(200); // OK
            echo json_encode([
                'id' => $course->getId(),
                'name' => $course->getName(),
                'degreeId' => $course->getDegreeId(),
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    public function getAllCourses(): void
    {
        try {
            $courses = $this->courseService->getAllCourses();
            http_response_code(200); // OK
            echo json_encode(array_map(fn($course) => [
                'id' => $course->getId(),
                'name' => $course->getName(),
                'degreeId' => $course->getDegreeId(),
            ], $courses));
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteCourse(Request $request, int $id): void
    {
        try {
            $this->courseService->deleteCourse($id);
            http_response_code(204); // No Content
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }
}
