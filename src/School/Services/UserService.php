<?php

namespace App\School\Services;

use App\School\Repositories\Interfaces\IUserRepository;
use App\School\Entities\User;

class UserService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function addUser(string $firstName, string $lastName, string $email, string $password, string $userType): User
    {
        if (empty($firstName) || empty($lastName)) {
            throw new \InvalidArgumentException("El nombre y el apellido son obligatorios.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("El formato del correo electrónico no es válido.");
        }

        $user = new User($firstName, $lastName, $email, $password, $userType);
        $this->userRepository->add($user);

        return $user;
    }

    public function updateUser(int $id, string $firstName, string $lastName, string $email, string $password, string $userType): void
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new \Exception("Usuario con ID $id no encontrado.");
        }

        $user->setFirstName($firstName)
            ->setLastName($lastName)
            ->setEmail($email)
            ->setPassword($password)
            ->setUserType($userType);

        $this->userRepository->update($user);
    }

    public function deleteUser(int $id): void
    {
        $this->userRepository->delete($id);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }

    public function serializeUser(User $user): array
    {
        return [
            'id' => $user->getId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'user_type' => $user->getUserType(),
        ];
    }
}
