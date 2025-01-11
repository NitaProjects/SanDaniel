<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Subject;

interface ISubjectRepository
{
    public function save(Subject $subject): void; // Guarda o actualiza una asignatura.
    public function findById(int $id): ?Subject; // Encuentra una asignatura por su ID.
    public function findByCourseId(int $courseId): array; // Encuentra asignaturas por su curso.
    public function delete(int $id): void; // Elimina una asignatura por su ID.
    public function getAll(): array; // Devuelve todas las asignaturas.
}
