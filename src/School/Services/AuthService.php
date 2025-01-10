<?php

namespace App\School\Services;

use App\School\Repositories\UserRepository;

class AuthService {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login(string $email, string $password): bool {
        // Buscar usuario por email
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            return false; // Usuario no encontrado
        }

        // Verificar contraseña
        if (!password_verify($password, $user['password'])) {
            return false; // Contraseña incorrecta
        }

        // Iniciar sesión
        $_SESSION['user_id'] = $user['id'];
        return true;
    }

    public function logout() {
        session_destroy();
    }

    public function isAuthenticated(): bool {
        return isset($_SESSION['user_id']);
    }
}
