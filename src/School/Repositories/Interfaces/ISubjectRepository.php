<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Subject;

interface ISubjectRepository
{
    public function add(Subject $subject): void; // Añade una nueva asignatura.
    public function update(Subject $subject): void; // Actualiza una asignatura existente.
    public function findById(int $id): ?Subject; // Encuentra una asignatura por su ID.
    public function delete(int $id): void; // Elimina una asignatura por su ID.
    public function getAll(): array; // Devuelve todas las asignaturas.
}
