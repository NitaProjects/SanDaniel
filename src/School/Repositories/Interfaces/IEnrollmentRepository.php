<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Enrollment;

interface IEnrollmentRepository
{
    public function add(Enrollment $enrollment): void; // Inserta una nueva matrícula.
    public function update(Enrollment $enrollment): void; // Actualiza una matrícula existente.
    public function findById(int $id): ?Enrollment; // Encuentra una matrícula por su ID.
    public function delete(int $id): void; // Elimina una matrícula por su ID.
    public function getAll(): array; // Devuelve todas las matrículas.
}
