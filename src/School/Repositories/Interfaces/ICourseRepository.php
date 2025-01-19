<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Course;

interface ICourseRepository
{
    public function add(Course $course): void; // Añade un nuevo curso.
    public function update(Course $course): void; // Actualiza un curso existente.
    public function findById(int $id): ?Course; // Encuentra un curso por su ID.
    public function delete(int $id): void; // Elimina un curso por su ID.
    public function getAll(): array; // Devuelve todos los cursos.
}
