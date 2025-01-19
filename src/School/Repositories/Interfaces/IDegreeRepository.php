<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Degree;

interface IDegreeRepository
{
    public function add(Degree $degree): void; // Guarda o actualiza una titulación.
    public function update(Degree $degree): void; // Guarda o actualiza una titulación.
    public function findById(int $id): ?Degree; // Encuentra una titulación por su ID.
    public function delete(int $id): void; // Elimina una titulación por su ID.
    public function getAll(): array; // Devuelve todas las titulaciones.
}
