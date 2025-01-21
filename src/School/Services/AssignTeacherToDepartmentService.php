<?php

namespace App\School\Services;

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

    /**
     * Asignar un departamento a un profesor.
     *
     * @param int $teacherId
     * @param int $departmentId
     * @throws \InvalidArgumentException Si el profesor o el departamento no existen.
     * @throws \LogicException Si el departamento ya está asignado al profesor.
     */
    public function assignDepartmentToTeacher(int $teacherId, int $departmentId): void
    {
        // Validar existencia del profesor
        $teacher = $this->teacherRepository->findById($teacherId);
        if (!$teacher) {
            throw new \Exception("El profesor no existe.");
        }

        // Validar existencia del departamento
        $department = $this->departmentRepository->findById($departmentId);
        if (!$department) {
            throw new \Exception("El departamento no existe.");
        }

        // Validar si ya está asignado
        $assignments = $this->teacherRepository->getTeacherDepartments();
        foreach ($assignments as $assignment) {
            if ($assignment['teacher_id'] === $teacherId && $assignment['department_id'] === $departmentId) {
                throw new \Exception("El profesor ya tiene asignado este departamento.");
            }
        }

        // Asignar el departamento al profesor
        $this->teacherRepository->assignDepartment($teacherId, $departmentId);
    }

    /**
     * Eliminar un departamento asignado a un profesor.
     *
     * @param int $teacherId
     * @param int $departmentId
     * @throws \InvalidArgumentException Si el profesor o el departamento no existen.
     */
    public function removeDepartmentFromTeacher(int $teacherId, int $departmentId): void
    {
        // Validar profesor y departamento
        $this->validateTeacher($teacherId);
        $this->validateDepartment($departmentId);

        // Eliminar el departamento asignado al profesor
        $this->teacherRepository->removeDepartment($teacherId, $departmentId);
    }

    /**
     * Obtener todos los profesores.
     *
     * @return array
     */
    public function getAllTeachers(): array
    {
        return $this->teacherRepository->getAll();
    }

    /**
     * Obtener todos los departamentos.
     *
     * @return array
     */
    public function getAllDepartments(): array
    {
        return $this->departmentRepository->getAll();
    }

    /**
     * Obtener asignaciones de profesores a departamentos.
     *
     * @return array
     */
    public function getTeacherDepartments(): array
    {
        return $this->teacherRepository->getTeacherDepartments();
    }

    /**
     * Validar existencia de un profesor.
     *
     * @param int $teacherId
     * @throws \InvalidArgumentException Si el profesor no existe.
     */
    private function validateTeacher(int $teacherId): void
    {
        if (!$this->teacherRepository->findById($teacherId)) {
            throw new \InvalidArgumentException("El profesor con ID $teacherId no existe.");
        }
    }

    /**
     * Validar existencia de un departamento.
     *
     * @param int $departmentId
     * @throws \InvalidArgumentException Si el departamento no existe.
     */
    private function validateDepartment(int $departmentId): void
    {
        if (!$this->departmentRepository->findById($departmentId)) {
            throw new \InvalidArgumentException("El departamento con ID $departmentId no existe.");
        }
    }
}
