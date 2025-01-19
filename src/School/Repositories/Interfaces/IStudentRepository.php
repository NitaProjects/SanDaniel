<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Student;

interface IStudentRepository
{
    public function add(Student $student): void; // Agrega un nuevo estudiante.
    public function update(Student $student): void; // Actualiza un estudiante existente.
    public function findById(int $id): ?Student; // Encuentra un estudiante por su ID.
    public function delete(int $id): void; // Elimina un estudiante por su ID.
    public function getAll(): array; // Devuelve todos los estudiantes.
}
