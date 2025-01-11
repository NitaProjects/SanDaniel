<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Exam;

interface IExamRepository
{
    public function save(Exam $exam): void; // Guarda o actualiza un examen.
    public function findById(int $id): ?Exam; // Encuentra un examen por su ID.
    public function findBySubjectId(int $subjectId): array; // Encuentra todos los exámenes de una asignatura.
    public function delete(int $id): void; // Elimina un examen por su ID.
    public function getAll(): array; // Devuelve todos los exámenes.
}
