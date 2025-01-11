<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Student;

interface IStudentRepository
{
    public function save(Student $student): void; // Guarda o actualiza un estudiante.
    public function findById(int $id): ?Student; // Encuentra un estudiante por su ID.
    public function findByDni(string $dni): ?Student; // Encuentra un estudiante por su DNI.
    public function delete(int $id): void; // Elimina un estudiante por su ID.
    public function getAll(): array; // Devuelve todos los estudiantes.
}
