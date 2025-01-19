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

            http_response_code(201);
            echo json_encode([
                'id' => $user->getId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'user_type' => $user->getUserType(),
            ]);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getUserById(Request $request, int $id): void
    {
        try {
            $user = $this->userService->getUserById($id);

            if ($user) {
                http_response_code(200);
                echo json_encode([
                    'id' => $user->getId(),
                    'first_name' => $user->getFirstName(),
                    'last_name' => $user->getLastName(),
                    'email' => $user->getEmail(),
                    'user_type' => $user->getUserType(),
                ]);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'User not found']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function updateUser(Request $request, int $id): void
    {
        try {
            $data = $request->getBody();

            if (!isset($data['first_name'], $data['last_name'], $data['email'], $data['password'], $data['user_type'])) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required fields']);
                return;
            }

            $this->userService->updateUser(
                $id,
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['password'],
                $data['user_type']
            );

            http_response_code(200);
            echo json_encode(['message' => 'User updated successfully']);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function deleteUser(Request $request, int $id): void
    {
        try {
            $this->userService->deleteUser($id);

            http_response_code(204);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getAllUsers(): void
{
    try {
        $users = $this->userService->getAllUsers();

        // Convertir los objetos `User` a arrays
        $userArray = array_map(fn($user) => $user->toArray(), $users);

        echo json_encode($userArray);
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
}

}
