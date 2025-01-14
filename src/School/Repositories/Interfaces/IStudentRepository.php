<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Student;

interface IStudentRepository
{
    public function save(Student $student): void; // Guarda o actualiza un estudiante.
    public function findById(int $id): ?Student; // Encuentra un estudiante por su ID.
    public function findByDni(string $dni): ?Student; // Encuentra un estudiante por su DNI.
    public function findByUserId(int $userId): ?Student; // Encuentra un estudiante por el ID de usuario.
    public function findByEnrollmentYear(int $year): array; // Encuentra estudiantes por el año de inscripción.
    public function delete(int $id): void; // Elimina un estudiante por su ID.
    public function getAll(): array; // Devuelve todos los estudiantes.
}
