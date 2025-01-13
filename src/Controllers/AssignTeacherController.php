<?php

namespace App\Controllers;

use App\Database\Database;
use App\School\Repositories\Implementations\TeacherRepository;
use App\School\Repositories\Implementations\DepartmentRepository;

class AssignTeacherController
{
    private TeacherRepository $teacherRepository;
    private DepartmentRepository $departmentRepository;

    public function __construct()
    {
        $database = new Database();
        $this->departmentRepository = new DepartmentRepository($database->getConnection());
        $this->teacherRepository = new TeacherRepository($database->getConnection(), $this->departmentRepository);
    }

    public function assignTeacherPage()
    {
        $teachers = $this->teacherRepository->getAll();
        $departments = $this->departmentRepository->getAll();
        $data = [
            'teachers' => $teachers,
            'departments' => $departments,
        ];
        echo view('assign-teacher', $data);
    }

    public function assignTeacherAction()
    {
        $teacherId = $_POST['teacher_id'] ?? null;
        $departmentId = $_POST['department_id'] ?? null;
        if (!$teacherId || !$departmentId) {
            header('Location: /assign-teacher?error=invalid-input');
            exit;
        }

        $teacher = $this->teacherRepository->findByUserId($teacherId);
        $department = $this->departmentRepository->findById($departmentId);

        if ($teacher && $department) {
            $teacher->addToDepartment($department);
            $this->teacherRepository->save($teacher);
        }

        header('Location: /assign-teacher');
    }

    public function deleteDepartmentAction()
    {
        $teacherId = $_POST['teacher_id'] ?? null;
        $departmentId = $_POST['department_id'] ?? null;
    
        if ($teacherId && $departmentId) {
            $this->teacherRepository->deleteByTeacherAndDepartment($teacherId, $departmentId);
            echo json_encode(['success' => true, 'message' => 'Departamento eliminado correctamente.']);
            http_response_code(200);
        } else {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
            http_response_code(400);
        }
        exit;
    }
    

}
