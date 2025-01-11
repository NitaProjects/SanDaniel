<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Teacher;

interface ITeacherRepository
{
    public function save(Teacher $teacher): void; // Guarda o actualiza un profesor.
    public function findById(int $id): ?Teacher; // Encuentra un profesor por su ID.
    public function findByUserId(int $userId): ?Teacher; // Encuentra un profesor por el ID de usuario.
    public function delete(int $id): void; // Elimina un profesor por su ID.
    public function getAll(): array; // Devuelve todos los profesores.
}
