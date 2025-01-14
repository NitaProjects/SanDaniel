<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\Course;

interface ICourseRepository
{
    public function save(Course $course): void; // Guarda o actualiza un curso.
    public function findById(int $id): ?Course; // Encuentra un curso por su ID.
    public function findByDegreeId(int $degreeId): array; // Encuentra cursos por el ID de la titulación.
    public function findByName(string $name): array; // Encuentra cursos por su nombre.
    public function delete(int $id): void; // Elimina un curso por su ID.
    public function getAll(): array; // Devuelve todos los cursos.
}
