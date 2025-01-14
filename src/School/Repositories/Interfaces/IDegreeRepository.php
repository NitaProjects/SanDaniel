<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Degree;

interface IDegreeRepository
{
    public function save(Degree $degree): void; // Guarda o actualiza una titulación.
    public function findById(int $id): ?Degree; // Encuentra una titulación por su ID.
    public function findByDurationYears(int $years): array; // Encuentra titulaciones por su duración en años.
    public function delete(int $id): void; // Elimina una titulación por su ID.
    public function getAll(): array; // Devuelve todas las titulaciones.
}
