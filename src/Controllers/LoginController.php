<?php

namespace App\Controllers;

use App\School\Services\AuthService;

class LoginController {
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function showLoginForm() {
        include '../views/login.view.php'; // Ruta al formulario de login
    }

    public function handleLogin() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($this->authService->login($email, $password)) {
            header("Location: /home"); // Redirigir a la página principal
        } else {
            echo "Credenciales incorrectas";
        }
    }

    public function logout() {
        $this->authService->logout();
        header("Location: /login");
    }
}
