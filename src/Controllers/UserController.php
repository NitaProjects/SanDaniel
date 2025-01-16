<?php

namespace App\Controllers;

use App\Infrastructure\Routing\Request;
use App\School\Services\UserService;

class UserController {
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function createUser(Request $request): void {
        try {
            $data = $request->getBody();
            $user = $this->userService->createUser(
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['password'],
                $data['user_type']
            );

            http_response_code(201);
            echo json_encode($user);
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getUserById(Request $request): void {
        try {
            $id = (int) ($_GET['id'] ?? 0); // Accede directamente al parámetro de la query
            if (!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing or invalid ID']);
                return;
            }
    
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
    

    public function deleteUser(Request $request): void {
        try {
            $id = (int) $request->getQueryParams()['id'];
            $this->userService->deleteUser($id);

            http_response_code(204);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function getAllUsers(): void {
        try {
            $users = $this->userService->getAllUsers();
            // Convertimos cada usuario a un array para evitar problemas con json_encode
            $usersArray = array_map(fn($user) => [
                'id' => $user->getId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'user_type' => $user->getUserType(),
            ], $users);
    
            http_response_code(200);
            echo json_encode($usersArray);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }
    

    public function searchUsers(Request $request): void {
        try {
            $criteria = $request->getQueryParams();
            $users = $this->userService->findByCriteria($criteria);

            http_response_code(200);
            echo json_encode($users);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }
}
