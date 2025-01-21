<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Teacher;

interface ITeacherRepository
{
    public function add(Teacher $teacher): void; // Agregar un nuevo profesor.
    public function update(Teacher $teacher): void; // Actualizar un profesor existente.
    public function delete(int $id): void; // Eliminar un profesor por su ID.
    public function findById(int $id): ?Teacher; // Encontrar un profesor por su ID.
    public function getAll(): array; // Listar todos los profesores.

    // Gestión de departamentos
    public function assignDepartment(int $teacherId, int $departmentId): void; // Asignar un departamento.
    public function removeDepartment(int $teacherId, int $departmentId): void; // Eliminar un departamento específico.
}
