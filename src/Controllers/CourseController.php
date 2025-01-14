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

    public function createCourse(Request $request)
    {
        $data = $request->getBody();
        $name = $data['name'] ?? null;
        $degreeId = $data['degreeId'] ?? null;

        if (!$name || !$degreeId) {
            http_response_code(400);
            echo json_encode(['error' => 'Name and degreeId are required']);
            return;
        }

        $course = $this->courseService->createCourse($name, (int)$degreeId);
        echo json_encode($course);
    }

    public function getCourseById(Request $request, int $id)
    {
        $course = $this->courseService->getCourseById($id);

        if (!$course) {
            http_response_code(404);
            echo json_encode(['error' => 'Course not found']);
            return;
        }

        echo json_encode($course);
    }

    public function getAllCourses()
    {
        $courses = $this->courseService->getAllCourses();
        echo json_encode($courses);
    }

    public function deleteCourse(Request $request, int $id)
    {
        $this->courseService->deleteCourse($id);
        http_response_code(204); // No Content
    }
}
