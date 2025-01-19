<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\User;

interface IUserRepository
{
    public function add(User $user): void; // Agrega un nuevo usuario.
    public function update(User $user): void; // Actualiza un usuario existente.
    public function delete(int $id): void; // Elimina un usuario por su ID.
    public function findById(int $id): ?User; // Encuentra un usuario por su ID.
    public function getAll(): array; // Devuelve todos los usuarios.
}
