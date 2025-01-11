<?php

namespace App\Controllers;

use App\Database\Database;
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Repositories\Implementations\CourseRepository;

class AssignStudentController
{
    private StudentRepository $studentRepository;
    private CourseRepository $courseRepository;

    public function __construct()
    {
        $database = new Database(); // Crear conexión a la base de datos
        $this->studentRepository = new StudentRepository($database->getConnection());
        $degreeRepo = new \App\School\Repositories\Implementations\DegreeRepository($database->getConnection());
        $this->courseRepository = new CourseRepository($database->getConnection(), $degreeRepo);
    }

    public function assignStudentPage()
    {
        $students = $this->studentRepository->getAll();
        $courses = $this->courseRepository->getAll();
        $studentsWithoutCourse = array_filter($students, fn($student) => !$student->getEnrollments());
        $data = [
            'students' => $students,
            'courses' => $courses,
            'studentsWithoutCourse' => $studentsWithoutCourse,
        ];
        echo view('assign-student', $data);
    }

    public function assignStudentAction()
    {
        $studentId = $_POST['student_id'] ?? null;
        $courseId = $_POST['course_id'] ?? null;

        if (!$studentId || !$courseId) {
            header('Location: /assign-student?error=invalid-input');
            exit;
        }

        $student = $this->studentRepository->findById($studentId);
        $course = $this->courseRepository->findById($courseId);

        if ($student && $course) {
            $student->addCourse($course); // Agregar curso al estudiante
            $this->studentRepository->save($student);
        }

        header('Location: /assign-student');
    }
}
