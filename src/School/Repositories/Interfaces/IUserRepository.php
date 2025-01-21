<?php

namespace App\School\Repositories\Interfaces;

use App\School\Entities\User;

interface IUserRepository
{
    public function add(User $user): void;
    public function update(User $user): void; 
    public function delete(int $id): void; 
    public function findById(int $id): ?User; 
    public function getAll(): array;
}