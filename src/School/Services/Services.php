<?php

namespace App\School\Services;

use App\School\Repositories\Implementations\TeacherRepository;
use App\School\Repositories\Implementations\DepartmentRepository;
use App\School\Repositories\Implementations\StudentRepository;
use App\School\Repositories\Implementations\EnrollmentRepository;
use App\School\Repositories\Implementations\CourseRepository;

class Services
{
    private array $services = [];
    private array $instances = [];

    public function __construct($db) // Recibe la conexión PDO
    {
        // Registro inicial de servicios básicos
        $this->addServices('teacherService', fn() => new \App\School\Services\AssignTeacherToDepartmentService(
            new TeacherRepository($db, new DepartmentRepository($db)),
            new DepartmentRepository($db)
        ));

        $this->addServices('studentService', fn() => new \App\School\Services\AssignStudentToCourseService(
            new StudentRepository($db),
            new EnrollmentRepository($db)
        ));
    }

    public function addServices(string $service, callable $def): void
    {
        $this->services[$service] = $def;
    }

    public function getService(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new \Exception("Service $name not found");
        }
        if (!isset($this->instances[$name])) {
            $this->instances[$name] = $this->services[$name]($this);
        }
        return $this->instances[$name];
    }

    public function hasService(string $name): bool
    {
        return isset($this->services[$name]);
    }
}
