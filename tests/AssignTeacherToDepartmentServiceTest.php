<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\AssignTeacherToDepartmentService;
use App\School\Entities\Teacher;
use App\School\Entities\Department;
use App\School\Repositories\Implementations\TeacherRepository;
use App\School\Repositories\Implementations\DepartmentRepository;

class AssignTeacherToDepartmentServiceTest extends TestCase
{
    public function testAssignTeacherToDepartment(): void
    {
        // Mock de TeacherRepository
        $teacherRepo = $this->createMock(TeacherRepository::class);
        $teacherRepo->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn(new Teacher("John", "Doe", "john@example.com", "password", "teacher"));

        $teacherRepo->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Teacher $teacher) {
                return $teacher->getDepartment() !== null;
            }));

        // Mock de DepartmentRepository
        $departmentRepo = $this->createMock(DepartmentRepository::class);
        $departmentRepo->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn(new Department("Mathematics"));

        // Servicio que estamos probando
        $service = new AssignTeacherToDepartmentService($teacherRepo, $departmentRepo);

        // Entidades para la prueba
        $teacher = new Teacher("John", "Doe", "john@example.com", "password", "teacher");
        $teacher->setId(1);

        $department = new Department("Mathematics");
        $department->setId(1);

        // Ejecutar el caso de uso
        $service->assign($teacher, $department);

        // Si no hay excepciones, la prueba pasa.
        $this->assertTrue(true);
    }
}
