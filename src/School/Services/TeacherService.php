<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\ITeacherRepository;
use App\School\Entities\Teacher;

class TeacherService
{
    private ITeacherRepository $teacherRepository;

    public function __construct(ITeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Crear un nuevo profesor asociado a un usuario existente.
     */
    public function addTeacher(int $userId): Teacher
    {
        $teacher = new Teacher('', '', '', '', $userId);
        $this->teacherRepository->add($teacher);

        return $teacher; // Devolvemos la instancia creada con su ID configurado
    }

    /**
     * Obtener un profesor por su ID.
     */
    public function getTeacherById(int $id): ?Teacher
    {
        return $this->teacherRepository->findById($id);
    }

    /**
     * Actualizar un profesor existente.
     */
    public function updateTeacher(int $id, int $userId): void
    {
        $teacher = $this->getTeacherById($id);

        if (!$teacher) {
            throw new \Exception("Teacher with ID $id not found.");
        }

        $teacher->setUserId($userId);

        $this->teacherRepository->update($teacher);
    }

    /**
     * Eliminar un profesor por su ID.
     */
    public function deleteTeacher(int $id): void
    {
        $this->teacherRepository->delete($id);
    }

    /**
     * Obtener todos los profesores.
     */
    public function getAllTeachers(): array
    {
        return $this->teacherRepository->getAll();
    }

    // -------------------------------
    // Gestión de Departamentos
    // -------------------------------

    /**
     * Obtener los departamentos asignados a un profesor.
     */
    public function getDepartmentsForTeacher(int $teacherId): array
    {
        return $this->teacherRepository->getDepartments($teacherId);
    }

    /**
     * Asignar un departamento a un profesor.
     */
    public function assignDepartmentToTeacher(int $teacherId, int $departmentId): void
    {
        // Validación opcional: Verificar si ya está asignado
        $departments = $this->getDepartmentsForTeacher($teacherId);
        foreach ($departments as $department) {
            if ($department['id'] === $departmentId) {
                throw new \Exception("El profesor ya tiene asignado este departamento.");
            }
        }

        $this->teacherRepository->assignDepartment($teacherId, $departmentId);
    }

    /**
     * Eliminar un departamento específico de un profesor.
     */
    public function removeDepartmentFromTeacher(int $teacherId, int $departmentId): void
    {
        $this->teacherRepository->removeDepartment($teacherId, $departmentId);
    }
}
