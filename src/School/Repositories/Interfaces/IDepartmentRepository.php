<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Department;

interface IDepartmentRepository
{
    public function save(Department $department): void; // Guarda o actualiza un departamento.
    public function findById(int $id): ?Department; // Encuentra un departamento por su ID.
    public function delete(int $id): void; // Elimina un departamento por su ID.
    public function getAll(): array; // Devuelve todos los departamentos.
}
