<?php

namespace App\School\Services;

use App\School\Entities\Teacher;
use App\School\Entities\Department;
use App\School\Repositories\Implementations\TeacherRepository;
use App\School\Repositories\Implementations\DepartmentRepository;

class AssignTeacherToDepartmentService
{
    private TeacherRepository $teacherRepository;
    private DepartmentRepository $departmentRepository;

    public function __construct(TeacherRepository $teacherRepo, DepartmentRepository $departmentRepo)
    {
        $this->teacherRepository = $teacherRepo;
        $this->departmentRepository = $departmentRepo;
    }

    public function assign(Teacher $teacher, Department $department): void
    {
        $teacher = $this->teacherRepository->findById($teacher->getId());
        if (!$teacher) {
            throw new \Exception("Teacher not found");
        }

        $department = $this->departmentRepository->findById($department->getId());
        if (!$department) {
            throw new \Exception("Department not found");
        }

        $teacher->addToDepartment($department);
        $this->teacherRepository->save($teacher);
    }
}
