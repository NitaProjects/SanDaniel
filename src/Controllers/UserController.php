<?php

namespace App\Controllers;

use App\Infrastructure\Routing\Request;
use App\School\Services\UserService;

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function addUser(Request $request): void
    {
        try {
            $data = $request->getBody();
            $user = $this->userService->addUser(
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['password'],
                $data['user_type']
            );

            $this->respond(201, $this->userService->serializeUser($user));
        } catch (\InvalidArgumentException $e) {
            $this->respond(400, ['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            $this->respond(500, ['error' => 'Error interno del servidor']);
        }
    }

    public function getUserById(Request $request, int $id): void
    {
        try {
            $user = $this->userService->getUserById($id);

            if ($user) {
                $this->respond(200, $this->userService->serializeUser($user));
            } else {
                $this->respond(404, ['error' => 'Usuario no encontrado']);
            }
        } catch (\Exception $e) {
            $this->respond(500, ['error' => 'Error interno del servidor']);
        }
    }

    public function updateUser(Request $request, int $id): void
    {
        try {
            $data = $request->getBody();
            $this->userService->updateUser(
                $id,
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['password'],
                $data['user_type']
            );

            $this->respond(200, ['message' => 'Usuario actualizado correctamente']);
        } catch (\InvalidArgumentException $e) {
            $this->respond(400, ['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            $this->respond(500, ['error' => 'Error interno del servidor']);
        }
    }

    public function deleteUser(Request $request, int $id): void
    {
        try {
            $this->userService->deleteUser($id);
            $this->respond(204);
        } catch (\Exception $e) {
            $this->respond(500, ['error' => 'Error interno del servidor']);
        }
    }

    public function getAllUsers(): void
    {
        try {
            $users = $this->userService->getAllUsers();
            $serializedUsers = array_map([$this->userService, 'serializeUser'], $users);

            $this->respond(200, $serializedUsers);
        } catch (\Exception $e) {
            $this->respond(500, ['error' => 'Error interno del servidor']);
        }
    }

    private function respond(int $status, array $data = []): void
    {
        http_response_code($status);
        if (!empty($data)) {
            echo json_encode($data);
        }
    }
}
