<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Enrollment;

interface IEnrollmentRepository
{
    public function save(Enrollment $enrollment): void; // Guarda o actualiza una matrícula.
    public function findById(int $id): ?Enrollment; // Encuentra una matrícula por su ID.
    public function findByStudentId(int $studentId): array; // Encuentra todas las matrículas de un estudiante.
    public function findBySubjectId(int $subjectId): array; // Encuentra todas las matrículas de una asignatura.
    public function delete(int $id): void; // Elimina una matrícula por su ID.
    public function getAll(): array; // Devuelve todas las matrículas.
}
