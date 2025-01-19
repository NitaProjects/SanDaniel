<?php

namespace App\Controllers;

use App\School\Services\DepartmentService;
use App\Infrastructure\Routing\Request;

class DepartmentController
{
    private DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function createDepartment(Request $request): void
    {
        try {
            $data = $request->getBody();
            $name = $data['name'] ?? null;

            if (!$name) {
                http_response_code(400);
                echo json_encode(['error' => 'Department name is required']);
                return;
            }

            $department = $this->departmentService->createDepartment($name);

            http_response_code(201);
            echo json_encode([
                'id' => $department->getId(),
                'name' => $department->getName(),
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    public function getDepartmentById(Request $request, int $id): void
    {
        try {
            $department = $this->departmentService->getDepartmentById($id);

            if (!$department) {
                http_response_code(404);
                echo json_encode(['error' => 'Department not found']);
                return;
            }

            http_response_code(200);
            echo json_encode([
                'id' => $department->getId(),
                'name' => $department->getName(),
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    public function getAllDepartments(): void
    {
        try {
            $departments = $this->departmentService->getAllDepartments();

            http_response_code(200);
            echo json_encode(array_map(function ($department) {
                return [
                    'id' => $department->getId(),
                    'name' => $department->getName(),
                ];
            }, $departments));
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteDepartment(Request $request, int $id): void
    {
        try {
            $this->departmentService->deleteDepartment($id);
            http_response_code(204); // No Content
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal Server Error', 'message' => $e->getMessage()]);
        }
    }
}
