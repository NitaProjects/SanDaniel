<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\User;

interface IUserRepository
{
    public function save(User $user): void; // Guarda o actualiza un usuario.
    public function findById(int $id): ?User; // Encuentra un usuario por su ID.
    public function findByEmail(string $email): ?User; // Encuentra un usuario por su email.
    public function findByUserType(string $userType): array; // Encuentra usuarios por tipo.
    public function findByName(string $firstName, string $lastName): array; // Filtra usuarios por nombre y apellido.
    public function findByCriteria(array $criteria): array; // Filtra usuarios por múltiples criterios.
    public function delete(int $id): void; // Elimina un usuario por su ID.
    public function getAll(): array; // Devuelve todos los usuarios.
}
