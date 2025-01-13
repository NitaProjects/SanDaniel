<?php

namespace App\Controllers;

use App\Database\Database;
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Repositories\Implementations\SubjectRepository;
use App\School\Repositories\Implementations\EnrollmentRepository;
use App\School\Repositories\Implementations\CourseRepository;
use App\School\Repositories\Implementations\DegreeRepository;

class AssignStudentController
{
    private StudentRepository $studentRepository;
    private SubjectRepository $subjectRepository;
    private EnrollmentRepository $enrollmentRepository;

    public function __construct()
    {
        $database = new Database();

        // Inicialización de DegreeRepository y CourseRepository
        $degreeRepository = new DegreeRepository($database->getConnection());
        $courseRepository = new CourseRepository($database->getConnection(), $degreeRepository);

        // Inicialización de SubjectRepository con CourseRepository
        $this->subjectRepository = new SubjectRepository($database->getConnection(), $courseRepository);

        // Inicialización de StudentRepository y EnrollmentRepository
        $this->studentRepository = new StudentRepository(
            $database->getConnection(),
            $this->subjectRepository,
            null // Se configurará después
        );
        $this->enrollmentRepository = new EnrollmentRepository(
            $database->getConnection(),
            $this->studentRepository,
            $this->subjectRepository
        );

        // Configuración mutua entre repositorios
        $this->studentRepository->setEnrollmentRepository($this->enrollmentRepository);
    }

    public function assignStudentPage()
    {
        $students = $this->studentRepository->getAll();
        $subjects = $this->subjectRepository->getAll();

        $data = [
            'students' => $students,
            'subjects' => $subjects,
        ];

        echo view('assign-student', $data);
    }

    public function assignStudentAction()
    {
        $studentId = $_POST['student_id'] ?? null;
        $subjectId = $_POST['subject_id'] ?? null;

        if (!$studentId || !$subjectId) {
            header('Location: /assign-student?error=invalid-input');
            exit;
        }

        $student = $this->studentRepository->findById($studentId);
        $subject = $this->subjectRepository->findById($subjectId);

        if ($student && $subject) {
            $enrollment = new \App\School\Entities\Enrollment($student, $subject, new \DateTime());
            $this->enrollmentRepository->save($enrollment);
        }

        header('Location: /assign-student');
    }

    public function deleteEnrollmentAction()
    {
        $enrollmentId = $_POST['enrollment_id'] ?? null;

        if ($enrollmentId) {
            $this->enrollmentRepository->delete($enrollmentId);
            echo json_encode(['success' => true, 'message' => 'Inscripción eliminada correctamente.']);
            http_response_code(200);
        } else {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
            http_response_code(400);
        }
        exit;
    }
}
