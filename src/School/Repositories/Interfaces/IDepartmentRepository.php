<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Department;

interface IDepartmentRepository
{
    public function add(Department $department): void; // Agrega un nuevo departamento.
    public function update(Department $department): void; // Actualiza un departamento existente.
    public function findById(int $id): ?Department; // Encuentra un departamento por su ID.
    public function delete(int $id): void; // Elimina un departamento por su ID.
    public function getAll(): array; // Devuelve todos los departamentos.
}
