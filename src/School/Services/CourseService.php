<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\ICourseRepository;
use App\School\Entities\Course;

class CourseService
{
    private ICourseRepository $courseRepository;

    public function __construct(ICourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function addCourse(string $name, int $degreeId): Course
    {
        $course = new Course($name, $degreeId);
        $this->courseRepository->add($course); // Usa add para agregar un nuevo curso.

        return $course;
    }

    public function updateCourse(int $id, string $name, int $degreeId): void
    {
        $course = $this->getCourseById($id);

        if (!$course) {
            throw new \Exception("Course with ID $id not found.");
        }

        $course->setName($name)
               ->setDegreeId($degreeId);

        $this->courseRepository->update($course); // Usa update para modificar un curso existente.
    }

    public function getCourseById(int $id): ?Course
    {
        return $this->courseRepository->findById($id);
    }

    public function deleteCourse(int $id): void
    {
        $this->courseRepository->delete($id);
    }

    public function getAllCourses(): array
    {
        return $this->courseRepository->getAll();
    }
}
